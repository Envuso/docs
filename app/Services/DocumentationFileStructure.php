<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use League\CommonMark\MarkdownConverter;
use Storage;

class DocumentationFileStructure
{

    private array $files = [];

    public function __construct()
    {
        $this->files = Storage::disk('docs')->files(null, true);
    }

    public static function clearCache()
    {
        Cache::tags('pages')->flush();
    }

    public static function cache()
    {
        return (new DocumentationFileStructure())->processFiles();
    }

    public function processFiles()
    {
        $fileLinks = Cache::get('links');

        $skipped = [];

        foreach ($this->files as $file) {
            $version            = Str::before($file, '/');
            $filePathWithoutExt = Str::replace('.md', '', $file);

            if (!isset($fileLinks[$version][$filePathWithoutExt])) {
                $skipped[] = $filePathWithoutExt;
                continue;
            }

            $link = $fileLinks[$version][$filePathWithoutExt];

            $contents = Storage::disk('docs')->get($file);

            Cache::tags('pages')->put($filePathWithoutExt, [
                'path'  => $filePathWithoutExt,
                'title' => $link['title'],
                'view'  => view('docs-page', [
                    'title' => $link['title'],
                    'html'  => $this->convertToHtml($contents),
                ])->render(),
            ]);
        }

        return $skipped;
    }

    public function convertToHtml(string $contents): string
    {
        $environment = new Environment([
            'table_of_contents' => [
                'html_class'        => 'table-of-contents',
                'position'          => 'top',
                'style'             => 'bullet',
                'min_heading_level' => 1,
                'max_heading_level' => 6,
                'normalize'         => 'relative',
                'placeholder'       => null,
            ],
            'heading_permalink' => [
                'symbol' => '#',
            ],
        ]);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());
        $environment->addExtension(new HeadingPermalinkExtension());
        $environment->addExtension(new TableOfContentsExtension());

        return (string)(new MarkdownConverter($environment))->convertToHtml($contents);
    }

}
