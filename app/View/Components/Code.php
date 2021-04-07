<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Code extends Component
{
    /**
     * Code constructor.
     *
     * @param string $whitespace
     * @param string $lang
     * @param bool   $inline
     */
    public function __construct(
        public $whitespace = '        ',
        public $lang = 'typescript',
        public $inline = false
    ) {  }

    public function render()
    {
        return function (array $data) {
            $formatted = str_replace($this->whitespace, '', $data['slot']);

            $class = $this->inline ? 'inline ' : 'regular';

            return '<pre class="'.$class.'"><code class="language-' . $this->lang . '">' . $formatted . '</code></pre>';
        };
    }
}
