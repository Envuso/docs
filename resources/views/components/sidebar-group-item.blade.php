<div>
    <a
        {{$attributes->class([
          'text-sm tracking-wide pl-4 py-1.5 hover:text-gray-50 transition text-gray-300 inline-block',
          'text-purple-400 font-medium' => $isActive
        ])}}
        href="{{$route}}">
        {{$text}}
    </a>
</div>
