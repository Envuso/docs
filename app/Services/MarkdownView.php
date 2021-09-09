<?php

namespace App\Services;

use Illuminate\Support\HtmlString;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Extension\Table\TableExtension;
use Storage;

class MarkdownView
{

    public static function parse($filename): HtmlString
    {
        $filename = \Str::afterLast($filename, '/');
        if (\Str::endsWith($filename, '.md')) {
            $filename = str_replace('.md', '', $filename);
        }
        $filename = \Str::afterLast($filename, '.');

        $version    = session()->get('version', 'v2');
        $versionDir = $version === 'v2' ? '2.0' : '1.0';

        $filepath = resource_path("docs/{$versionDir}/{$filename}");

        if (!\Str::endsWith($filepath, '.md')) {
            $filepath .= '.md';
        }

        $text = file_get_contents($filepath);

        $converter = new CommonMarkConverter([
            'allow_unsafe_links' => false,
        ]);

        $converter->getEnvironment()->addExtension(new TableExtension());

        return new HtmlString((string)$converter->convertToHtml($text));
    }

}
