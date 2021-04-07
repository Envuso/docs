<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SidebarGroupItem extends Component
{
    public $route;
    public $text;
    public $isActive = false;

    /**
     * Create a new component instance.
     *
     * @param $route
     * @param $text
     */
    public function __construct($route, $text)
    {
        $this->route = $route;
        $this->text  = $text;

        if (request()->fullUrlIs($route)) {
            $this->isActive = true;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar-group-item');
    }
}
