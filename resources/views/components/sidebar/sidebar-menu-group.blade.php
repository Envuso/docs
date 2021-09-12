<x-sidebar.sidebar-item-group :item="$item">
    {{--@if($item->hasChildren())
        @foreach($item->children() as $child)
            <x-sidebar.sidebar-menu-group :item="$child" />
        @endforeach
    @endif--}}
    @if($item->hasPages())
        @foreach($item->pages() as $page)
            <x-sidebar-group-item :route="$page->route()" :text="$page->title()" />
        @endforeach
    @endif
</x-sidebar.sidebar-item-group>

