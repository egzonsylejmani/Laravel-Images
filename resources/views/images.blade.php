<!-- resources/views/posts/index.blade.php -->

@extends('layouts.app')
@section('content')
    <div class="px-20 py-20 flex flex-col gap-4 h-full bg-red-100">
        <h1> All Images</h1>
        @foreach ($posts as $post)
            <div class="flex flex-col border-b-4 border-black">
                <h2>{{ $post->title }}</h2>
                <p>{{ $post->description }}</p>
                @if ($post->images->count() > 0)
                    <ul class="grid grid-cols-2 md:grid-cols-5 lg:grid-cols-7 gap-4">
                        @foreach ($post->images as $image)
                            <li class="w-40 h-40">
                                @if (pathinfo($image->path, PATHINFO_EXTENSION) === 'mov')
                                    <video class="w-26 h-26" controls>
                                        <source src="{{ asset('storage/images/' . $image->path) }}" type="video/quicktime">

                                    </video>
                                @else
                                    <img class="w-40 h-40 rounded" src="{{ asset('storage/images/' . $image->path) }}"
                                        alt="{{ $image->name }}" />
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
                <form action="{{ url('/posts/' . $post->id . '/download') }}" method="get">
                    @csrf
                    <button type="submit" class="bg-blue-300 rounded-lg  px-2 py-2 mb-4">Download Images</button>
                </form>
            </div>

        @endforeach

    </div>
@endsection
