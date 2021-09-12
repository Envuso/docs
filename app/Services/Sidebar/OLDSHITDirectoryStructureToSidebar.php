<?php

namespace App\Services;

use Cache;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;
use JetBrains\PhpStorm\ArrayShape;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use League\CommonMark\GithubFlavoredMarkdownConverter;
use League\CommonMark\MarkdownConverter;
use Nette\Schema\Expect;
use Storage;
use Str;

class MarkdownStructureParser
{

    private array $structure   = [];
    private array $paths       = [];
    private array $versions    = [];
    private array $sidebar     = [];
    private array $groupRoutes = [];

    public function __construct()
    {
        $this->getDirectoryStructure();

        Cache::put('sidebar', $this->sidebar);

        Cache::put('docs', [
            'versions'  => $this->versions,
            'structure' => $this->structure,
        ]);
    }

    public static function create(): static
    {
        return new static();
    }

    private function getDirectoryStructure()
    {
        $this->versions = Storage::disk('docs')->directories(null, false);

        dd(
            Storage::disk('docs')->files(null, true)
        );

        $structure = [];
        $sidebar   = [];

        foreach ($this->versions as $version) {
            [$struct, $sidebarItem] = $this->parseStructure($version);

            if ($struct !== null) {
                $structure[$version] = $struct;
                $sidebar[]           = $sidebarItem;
            }
        }

        $this->sidebar   = $sidebar;
        $this->structure = $structure;
    }

    #[ArrayShape(['files' => "array", 'sub' => "array", 'path' => "null|string"])]
    private function parseStructure(string|null $path): ?array
    {
        [$files, $sidebarPages] = $this->parseFiles(Storage::disk('docs')->files($path, false));

        $pageRoute = Str::replace('.md', '', $path);

        Redis::hSet('groups', $pageRoute, json_encode([
            'title' => strval(Str::of($path)->title()->afterLast('/')),
            'route' => $pageRoute,
        ]));

        $directory = [
            'files' => $files,
            'sub'   => [],
            'path'  => $path,
            'route' => $pageRoute,
        ];

        $sidebarItem = [
            'title' => strval(Str::of($path)->title()->afterLast('/')),
            'route' => $pageRoute,
            'pages' => $sidebarPages,
            'sub'   => [],
        ];

        $structure = Storage::disk('docs')->directories($path, false);

        foreach ($structure as $subPath) {
            if ([$sub, $sidebarSub] = $this->parseStructure($subPath)) {
                $directory['sub'][$subPath] = $sub;

                $sidebarItem['sub'][] = $sidebarSub;
            }
        }


        if (empty($directory['sub']) && empty($directory['files'])) {
            return null;
        }

        return [$directory, $sidebarItem];
    }

    /**
     * @return array
     */
    public function getStructure(): array
    {
        return [
            'paths'     => $this->paths,
            'structure' => $this->structure,
        ];
    }

    private function parseFiles(array $files)
    {
        $mappedFiles  = [];
        $sidebarPages = [];

        foreach ($files as $file) {
            $contents = Storage::disk('docs')->get($file);

            Cache::put($file, $contents);

            $contents = trim(strip_tags($contents));

            $this->paths[] = $file;

            $lines = array_map(fn($line) => trim($line), explode("\n", $contents));
            $lines = array_filter($lines, fn($line) => trim($line) !== '');

            $filePathWithoutExt = Str::replace('.md', '', $file);

            $sidebarPages[] = [
                'title' => Str::substr(array_shift($lines), 2),
                'route' => $filePathWithoutExt,
            ];

            Cache::tags('pages')->put($filePathWithoutExt, [
                'path'  => $filePathWithoutExt,
                'title' => Str::substr(array_shift($lines), 2),
                'html'  => $this->parseMarkdown($contents),
            ]);

            $mappedFiles[$file] = [
                'path'     => $file,
                'title'    => Str::substr(array_shift($lines), 2),
                'sections' => $this->getFileSections($contents, $filePathWithoutExt),
            ];
        }

        return [$mappedFiles, $sidebarPages];
    }

    private function getFileSections(string $contents, $filePathWithoutExt)
    {
        $lines = explode("\n", $contents);

        $sections = [];

        $currentSection = [
            'title'    => null,
            'link'     => null,
            'children' => [],
            'is_main'  => false,
        ];

        for ($i = 0; $i < count($lines); $i++) {
            $line = $lines[$i];

            $isSectionStart = Str::startsWith($line, ['#', '##', '###', '####']);
            $isChildSection = Str::startsWith($line, ['##', '###', '####']);

            if ($isSectionStart) {
                if ($currentSection['title'] === null) {
                    $currentSection['title']   = trim(Str::replace('#', '', $line));
                    $currentSection['link']    = trim($line);
                    $currentSection['is_main'] = Str::startsWith($line, '# ');
                } else {
                    if ($isChildSection) {
                        $currentSection['children'][] = [
                            'title' => trim(Str::replace('#', '', $line)),
                            'link'  => trim($line),
                        ];
                        continue;
                    }

                    $sections[] = [
                        'title'    => $currentSection['title'],
                        'link'     => $currentSection['link'],
                        'children' => $currentSection['children'],
                        'is_main'  => $currentSection['is_main'],
                    ];

                    $currentSection = [
                        'title'    => null,
                        'link'     => null,
                        'is_main'  => false,
                        'children' => [],
                    ];

                }
            }
        }

        if ($currentSection['title'] !== null) {
            $sections[] = $currentSection;
        }

        Cache::tags(['pages', 'sections'])->put($filePathWithoutExt, $sections);

        return $sections;
    }

    public function parseMarkdown(string $contents)
    {
        $environment = new Environment([
            'table_of_contents' => [
                'html_class'        => 'table-of-contents',
                'position'          => 'top',
                'style'             => 'bullet',
                'min_heading_level' => 2,
                'max_heading_level' => 6,
                'normalize'         => 'relative',
                'placeholder'       => null,
            ],
            'heading_permalink' => [
                'min_heading_level' => 2,
                'symbol'            => '#',
            ],
        ]);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());
        $environment->addExtension(new HeadingPermalinkExtension());
        $environment->addExtension(new TableOfContentsExtension());

        return (string)(new MarkdownConverter($environment))->convertToHtml($contents);
    }
}
