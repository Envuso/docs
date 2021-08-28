<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InlineCode extends Component
{
    /**
     * Code constructor.
     *
     * @param string $lang
     */
    public function __construct(public string $lang = 'typescript',)
    {
    }

    public function render()
    {
        return function (array $data) {
            return '<code class="language-'.$this->lang.'">' . $data['slot'] . '</code>';
        };
    }
}
