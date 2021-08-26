<a
    {{$attributes->class([
      'tracking-wide py-1.5 text-purple-400 hover:text-purple-200 transition',
    ])}}
    href="{{$route}}">
    {{$text ?? $slot}}
</a>

