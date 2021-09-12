<div>
    <a
        {{$attributes->class([
            'inline-block',
			'select-none',
            'menu-item',
            'menu-item-active' => $isActive,
            'flex w-full items-center hover:translate-x-0.5 transition transform ease-in-out',
            'ml-3' => $isChild === false,
            'ml-3' => $isChild === true,
        ])}}
        href="{{$route}}"
        data-load-page="{{$route}}"
        data-load-title="{{$text}}"
    >
        <div {{$attributes->class(['align-items-center block flex items-center mr-1.5'])}} >
            <span class="w-1.5 h-1.5 rounded-full inline-flex bg-purple-300"></span>
        </div>
        <p class="">{{$text}}</p>

    </a>
</div>
