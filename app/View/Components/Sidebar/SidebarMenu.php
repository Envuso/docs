<?php

namespace App\View\Components\Sidebar;

use App\Services\Sidebar\SidebarMenus;
use Illuminate\View\Component;

class SidebarMenu extends Component
{
    public function render()
    {
        return view('components.sidebar.sidebar-menu', ['items' => SidebarMenus::getMenu()]);
    }
}
