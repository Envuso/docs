@if(isset($html))
    <p class="text-white text-3xl tracking-wide font-bold mb-6">
        {{$title}}
    </p>
@endif

{!! $html ?? $view !!}

{{--{{dd($html ?? $view)}}--}}

