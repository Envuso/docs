<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InlineCode extends Component
{
    /**
     * Code constructor.
     *
     * @param string $whitespace
     * @param string $lang
     */
    public function __construct(
        public string $whitespace = '        ',
        public string $lang = 'typescript',
    )
    {
    }

    public function render()
    {
        return function (array $data) {
            $formatted = str_replace($this->whitespace, '', $data['slot']);

            return '<pre class="inline inline-flex"><code class="language-' . $this->lang . '">' . $formatted . '</code></pre>';
        };
    }
}
