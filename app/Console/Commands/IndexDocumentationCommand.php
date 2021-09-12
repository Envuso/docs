<?php

namespace App\Console\Commands;

use Algolia\AlgoliaSearch\SearchClient;
use Illuminate\Console\Command;

class IndexDocumentationCommand extends Command
{
	protected $signature = 'index:docs';

	protected $description = 'Command description';

	public function handle()
	{

        $client = SearchClient::create(
            config('services.algolia.key'),
            config('services.algolia.secret'),
        );

        $index = $client->initIndex(config('services.algolia.index'));


	}
}
