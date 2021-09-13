<?php

namespace App\Console\Commands;

use Algolia\AlgoliaSearch\SearchClient;
use App\Services\Sidebar\SidebarMenus;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Parsedown;
use ParsedownExtra;
use Storage;

class IndexDocumentationCommand extends Command
{
    protected $signature = 'docs:index';

    protected                                  $description = 'Command description';
    private \Algolia\AlgoliaSearch\SearchIndex $index;

    public function handle()
    {

        $client = SearchClient::create(
            config('services.algolia.key'),
            config('services.algolia.secret'),
        );


        foreach (SidebarMenus::links() as $version => $pages) {

            $this->index = $client->initIndex(config('services.algolia.index') . '_' . $version);

            $this->indexVersionPages($version, $pages);
        }

    }

    private function indexVersionPages($version, mixed $pages)
    {
        $disk = Storage::disk('docs');


        foreach ($pages as $path => $page) {

            $filePath = $path . '.md';

            if (!$disk->exists($filePath)) {
                continue;
            }
            $parseDown = new CustomParser();

            $contents = $disk->get($filePath);

            $parseDown->parse($contents);

            $results = $parseDown->results();

            $sections = [];

            foreach ($results as $result) {
                if (empty($result['lines'])) {
                    continue;
                }
                $sections[] = [
                    'title'    => $result['header']['text'],
                    'url'      => "{$page['route']}#content-" . \Str::slug($result['header']['text']),
                    'contents' => implode("\n", $result['lines']),
                ];
            }

            $this->index->saveObjects($sections, ['autoGenerateObjectIDIfNotExist' => true]);

        }
    }
}
