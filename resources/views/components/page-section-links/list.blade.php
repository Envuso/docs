<div>

    <div class="table-of-contents">

    </div>
    @foreach($page['sections'] as $section)

        <x-page-section-links.title>
            {{$section['title']}}
        </x-page-section-links.title>

        @if(!empty($section['children']))
            @foreach($section['children'] as $child)
                <x-page-section-links.sub-title>
                    {{$child['title']}}
                </x-page-section-links.sub-title>
            @endforeach
        @endif
    @endforeach
</div>
