<?php

namespace App\Services\Sidebar;

class SidebarItem
{
    private ?SidebarItem $parent   = null;
    private ?string      $title    = null;
    private ?string      $route    = null;
    private ?array       $pages    = [];
    private ?array       $children = [];

    public function __construct($item, $parent = null)
    {
        $this->parent = $parent;
        $this->title  = $item['title'];
        $this->route  = $item['route'];

        if (!empty($item['pages']) && isset($item['pages'])) {
            foreach ($item['pages'] as $page) {
                $this->pages[] = new SidebarItem($page, $this);
            }
        }
        //if (!empty($item['sub']) && isset($item['sub'])) {
        //    foreach ($item['sub'] as $subItem) {
        //        $this->children[] = new SidebarItem($subItem, $this);
        //    }
        //}
        // if (!empty($this->children)) {
        //     dd($this);
        // }
    }

    public function hasPages(): bool
    {
        return !empty($this->pages);
    }

    public function hasParent(): bool
    {
        return $this->parent !== null;
    }

    //public function hasChildren()
    //{
//
    //    return !empty($this->children);
    //}

    public function title()
    {
        return $this->title;
    }

    public function parent(): ?SidebarItem
    {
        return $this->parent;
    }

    public function rawRoute()
    {
        return $this->route;
    }

    public function route()
    {
        return route('page', $this->route);
    }

    /**
     * @return SidebarItem[]
     */
    public function pages(): array
    {
        return $this->pages;
    }
    //
    // /**
    //  * @return SidebarItem[]
    //  */
    // public function children(): array
    // {
    //     return $this->children;
    // }

}
