<div>
    <a
        {{$attributes->class([
          'text-sm tracking-wide py-1.5 hover:text-gray-50 transition text-gray-300 inline-block',
          'text-purple-400 font-medium' => $isActive,
          'pl-4' => $isChild === false,
          'pl-8' => $isChild === true,
        ])}}
        href="{{$route}}">
        {{$text}}
    </a>
</div>
