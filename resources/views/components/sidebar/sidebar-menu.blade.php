<div>
    <div id="sideMenu" class="sidebar " data-turbo-permanent>

        <x-sidebar-header />
        <x-sidebar.version-control />

        <div class="px-6 py-5">
            @foreach($items as $item)
                <x-sidebar.sidebar-menu-group :item="$item" />
            @endforeach
        </div>
    </div>
</div>
