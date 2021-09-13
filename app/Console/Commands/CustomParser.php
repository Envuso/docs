<?php

namespace App\Console\Commands;

use Parsedown;

class CustomParser extends \ParsedownExtra
{
    public $array_line = [];

    public $current = [
        'header' => null,
        'lines'  => [],
    ];

    public $sections = [];

    protected function blockHeader($Line)
    {
        // Parse $Line to parent class
        $Block = Parsedown::blockHeader($Line);

        // Set headings
        if (isset($Block['element']['name'])) {
            $Level              = (integer)trim($Block['element']['name'], 'h');
            $this->array_line[] = [
                'text'  => $Block['element']['text'],
                'level' => $Level,
            ];

            if ($this->current['header'] === null) {
                $this->current['header'] = [
                    'text'  => $Block['element']['text'],
                    'level' => $Level,
                ];
            } else {
                $this->sections[] = [
                    'header' => $this->current['header'],
                    'lines'  => $this->current['lines'],
                ];
                $this->current    = [
                    'header' => [
                        'text'  => $Block['element']['text'],
                        'level' => $Level,
                    ],
                    'lines'  => [],
                ];
            }
        }

        return $Block;
    }

    protected function paragraph($line)
    {
        $block = [
            'element' => [
                'name'    => 'p',
                'text'    => $line['text'],
                'handler' => 'line',
            ],
        ];

        if ($this->current['header']) {
            $this->current['lines'][] = $block['element']['text'];
        }

        return parent::blockHeader($line);
    }

    protected function inlineCode($Excerpt)
    {
        return parent::inlineBlock($Excerpt);
    }

    protected function blockCode($Line, $Block = null)
    {
        if (!in_array($Line['body'], $this->current['lines']) && $Block) {

            if (isset($Block['element']['text']['text'])) {
                $this->current['lines'][] = $Block['element']['text']['text'];
            }
        }

        return parent::blockCode($Line, $Block);
    }

    public function element(array $Element)
    {
        return parent::element($Element);
    }

    public function results()
    {
        return $this->sections;
    }
}
