@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
@if (session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
    <strong class="font-bold">Success!</strong>
    <span class="block sm:inline">{{ session('success') }}</span>
</div>
@endif
<div class="mx-auto max-w-7xl px-2  flex flex-col px-5">
    <div class="flex flex-col space-y-8 pb-10 pt-12 md:pt-24">
        <h1 class="text-3xl font-bold text-gray-900 md:text-5xl md:leading-10">Resources and Insights</h1>
        <p class="max-w-4xl text-base text-gray-600 md:text-xl">Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore veritatis voluptates neque itaque repudiandae sint, explicabo assumenda quam ratione placeat?</p>
        <div class="mt-6 flex w-full items-center space-x-2 md:w-1/3">
<form action="{{ route('index') }}" method="GET" class="flex gap-3">
    <input
      class="flex h-10 w-full rounded-md border border-black/30 bg-transparent px-3 py-2 text-sm placeholder:text-gray-600 focus:outline-none focus:ring-1 focus:ring-black/30 focus:ring-offset-1 disabled:cursor-not-allowed disabled:opacity-50"
      type="text"
      placeholder="Search Topics"
      name="search"
    />
    <button
      type="submit"
      class="rounded-md bg-black px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-black/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black"
    >
      Search
    </button>
    
</form>

      </div>
    </div>
    <div class="grid gap-6 gap-y-10 py-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($posts as $post)
        <div class="border">
        <a href="{{ route('posts.show', $post) }}" class="block">
            <img src="{{ Storage::url($post->image) }}" class="aspect-w-16 aspect-h-9 w-full rounded-md" alt="{{ $post->title }}" />
            <div class="min-h-min p-3">
                <p class="mt-4 text-xs font-semibold leading-tight text-gray-700">#{{ $post->title }}</p>
                <p class="mt-2 text-sm leading-normal text-gray-600">{{ $post->discription }}</p>
                <div class="flex items-center mt-4 space-x-3">
                    <div>
                        <p class="text-sm font-semibold leading-tight text-gray-900">{{ $post->user->name }}</p>
                        <p class="text-sm leading-tight text-gray-600">{{ $post->created_at->format('d F Y') }}</p>
                    </div>
                </div>
            </div>
        </a>
        </div>
        @endforeach
    </div>
    <div class="w-full border-t border-gray-300">
        <div class="mt-2 flex items-center justify-between">
            <p class="text-gray-600">Showing <strong>{{ $posts->firstItem() }}</strong> to <strong>{{ $posts->lastItem() }}</strong> of <strong>{{ $posts->total() }}</strong> results</p>
            <div class="flex space-x-2">
                @if ($posts->previousPageUrl())
                <a href="{{ $posts->previousPageUrl() }}" class="rounded-md bg-black px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-black/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">← Previous</a>
                @endif
                @if ($posts->nextPageUrl())
                <a href="{{ $posts->nextPageUrl() }}" class="rounded-md bg-black px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-black/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">Next →</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
