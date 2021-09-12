<?php

namespace App\Console\Commands;

use App\Services\Documentation;
use Illuminate\Console\Command;

class ProcessDocumentationCommand extends Command
{
    protected $signature = 'docs:process';

    protected $description = 'Process all of the documentation files and cache everything';

    public function handle()
    {
        Documentation::clearCaches();
        $skipped = Documentation::cacheData();

        $this->info('Successfully cached.');
        $this->info('There was some files skipped however...');
        foreach ($skipped as $s) {
            $this->info(" - $s");
        }

    }
}
