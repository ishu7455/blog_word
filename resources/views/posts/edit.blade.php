@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="bg-gray-100 py-6">
    <div class="max-w-lg mx-auto bg-white rounded-lg overflow-hidden shadow-md">
        <div class="px-4 py-2 border-b">
            <h2 class="text-xl font-bold">{{ __('Edit Post') }}</h2>
        </div>

        <div class="p-4">
            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Title') }}</label>
                    <input id="title" type="text" class="form-input w-full @error('title') border-red-500 @enderror" name="title" value="{{ $post->title }}" required autofocus>
                    @error('title')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Description') }}</label>
                    <textarea id="description" class="form-textarea w-full @error('description') border-red-500 @enderror" name="discription" required>{{($post->discription) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Image') }}</label>
                    <input id="image" type="file" class="form-input w-full @error('image') border-red-500 @enderror" name="image">
                    @error('image')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">{{ __('Update Post') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
