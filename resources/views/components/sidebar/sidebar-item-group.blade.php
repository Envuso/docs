<div class="py-2.5">
    <div data-group="{{$item->rawRoute()}}" class="flex flex-row item-group-title mb-0.5 cursor-pointer group ease-in-out transition transform hover:translate-x-0.5">
        <p
            class="item-group-title-text text-sm tracking-wide select-none text-gray-400 inline-block dropdown-sidebar m-0 group-hover:text-gray-100 ease-in-out transition transform "
        >
            {{$item->title()}}
        </p>
    </div>
    <div class="dropdown-container  mt-2.5" style="display:none">
        {{$slot}}
    </div>
</div>
