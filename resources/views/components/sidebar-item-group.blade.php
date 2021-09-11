<div class="py-3">
    <p id="sidebar-transition" class="text-lg tracking-wide text-gray-400 inline-block dropdown-sidebar cursor-pointer mb-0.5 active">
        {{$attributes['title']}}
    </p>
    <div class="dropdown-container" style="display: block;">
        {{$slot}}
    </div>
</div>
