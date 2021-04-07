<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Folder extends Component
{
    public $prefix;
    public $name;

    public function __construct($prefix, $name) {

        $this->prefix = $prefix;
        $this->name = $name;
    }

	/**
	 * Get the view / contents that represent the component.
	 *
	 * @return \Illuminate\View\View|string
	 */
	public function render()
	{
	    return view('components.folder');
	}
}
