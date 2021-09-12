<div>
    <a
        {{$attributes->class([
          'text-lg tracking-wide py-1.5 hover:text-gray-50 transition text-gray-300 inline-block',
          'text-purple-400 font-medium' => $isActive
        ])}}

        href="{{$route}}">
        {{$text}}
    </a>
</div>
