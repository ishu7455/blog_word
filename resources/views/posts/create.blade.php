@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
<div class="bg-gray-100 py-6">
    <div class="max-w-lg mx-auto bg-white rounded-lg overflow-hidden shadow-md">
        <div class="px-4 py-2 border-b">
            <h2 class="text-xl font-bold">{{ __('Create Post') }}</h2>
        </div>

        <div class="p-4">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Title') }}</label>
                    <input id="title" type="text" class="form-input w-full @error('title') border-red-500 @enderror" name="title" value="{{ old('title') }}" required autofocus>
                    @error('title')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

      <div class="mb-4">
          <label for="discription" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Destination') }}</label>
          <textarea id="destination" class="form-textarea w-full @error('discription') border-red-500 @enderror" name="discription" required>{{ old('discription') }}</textarea>
         @error('discription')
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
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">{{ __('Create Post') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
