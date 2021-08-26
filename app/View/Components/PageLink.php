<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PageLink extends Component
{
    public string  $route;
    public ?string $text = null;

    /**
     * Create a new component instance.
     *
     * @param             $route
     * @param string|null $text
     */
    public function __construct($route, string|null $text = null)
    {
        $this->route = $route;
        $this->text  = $text;
    }

    public function render()
    {
        return view('components.page-link');
    }
}
