<x-app-layout>

    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 justify-center">

                    <x-category-tag>
                        No categories
                    </x-category-tag>

                </div>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 text-gray-900 mt-8">
        @forelse($posts as $post)
            <x-post-item :post="$post"/>
        @empty
            <div>
                <p class="text-gray-900 text-center text-2xl">No posts found!!</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6 flex justify-center">
        {{ $posts->links() }}
    </div>

    </x-app-layout>
