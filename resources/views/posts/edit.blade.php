<x-app-layout>
    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl mb-4 ">Update Post: <strong class="font-bold">{{ $post->title }}</strong></h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('PUT')
                        @if ($post->imageUrl())
                            <div class="mb-8">
                                <img src="{{ $post->imageUrl() }}" class="w-24 h-24 object-cover rounded-full"
                                    alt="{{ $post->title }}" class="w-full" />
                            </div>
                        @endif
                        {{-- Image Upload --}}
                        <div>
                            <x-input-label for="image" :value="__('Image')" />
                            <input name="image" id="image" type="file"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:border-indigo-500 focus:ring-indigo-500" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        {{-- Title --}}
                        <div class="mt-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                                :value="old('title', $post->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        {{-- Category --}}
                        <div class="mt-4">
                            <x-input-label for="category_id" :value="__('Category')" />

                            <select id="category_id" name="category_id"
                                class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select a Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>


                        {{-- Content --}}
                        <div class="mt-4">
                            <x-input-label for="content" :value="__('Content')" />
                            <textarea id="content" name="content"
                                class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                rows="3" required>{{ old('content', $post->content) }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>
                        {{-- Published At --}}
                      <div class="mt-4">
                            <x-input-label for="published_at" :value="__('Published at')" />
 
                            <x-text-input id="published_at" class="block mt-1 w-full" type="datetime-local"
                                name="published_at"
                                :value="old('published_at', $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('Y-m-d\TH:i') : '')"
                                required autofocus />
 
                            <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                        </div>

                        {{-- Submit Button --}}
                        <x-primary-button class="mt-4">
                            {{ __('Submit') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
