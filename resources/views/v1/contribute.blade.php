@extends('v1.layout.app')

@section('content')

    <x-container>
        {{ Illuminate\Mail\Markdown::parse(file_get_contents(base_path() . '\resources\docs\1.0\contribute.md')) }}
    </x-container>



@endsection
