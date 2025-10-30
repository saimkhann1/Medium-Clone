@props(['post'])

<div class="bg-white border border-gray-200 rounded-2xl shadow-md mb-6 hover:shadow-lg transition-all duration-300 overflow-hidden group">
    <div class="flex flex-col sm:flex-row">

        {{-- Text Section --}}
        <div class="flex-1 p-6 flex flex-col justify-between">
            
            {{-- Title & Content --}}
            <div>
                <a href="{{ route('posts.show', ['username' => $post->user->username, 'post' => $post->slug]) }}">
                    <h2 class="text-2xl font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors duration-200">
                        {{ $post->title }}
                    </h2>
                </a>

                <p class="mt-3 text-gray-600 leading-relaxed text-sm">
                    {{ Str::words($post->content, 25) }}
                </p>
            </div>

            {{-- Footer Section --}}
            <div class="mt-5 flex flex-col sm:flex-row sm:items-center sm:justify-between text-sm text-gray-500 gap-3">

                {{-- Author Info --}}
                <div class="flex items-center">
                    <img 
                        src="{{ $post->user->imageUrl() ?? asset('images/default-avatar.png') }}"
                        alt="{{ $post->user->name }}"
                        class="w-9 h-9 rounded-full object-cover mr-3 border border-gray-300"
                    />
                    <div>
                        <p class="text-gray-600 text-sm">
                            Published by 
                            <a href="{{ route('profile.show', $post->user->username) }}" 
                               class="font-semibold text-indigo-600 hover:underline">
                                {{ $post->user->name }}
                            </a>
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ $post->created_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>

                {{-- Claps Info --}}
                <div class="flex items-center space-x-1 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 24 24" class="w-5 h-5 text-emerald-500">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 
                            0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 
                            4.498 0 0 0 .322-1.672V2.75a.75.75 
                            0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 
                            2.25c0 1.152-.26 2.243-.723 
                            3.218-.266.558.107 1.282.725 1.282h3.126c1.026 
                            0 1.945.694 2.054 1.715.045.422.068.85.068 
                            1.285a11.95 11.95 0 0 1-2.649 
                            7.521c-.388.482-.987.729-1.605.729H13.48c-.483 
                            0-.964-.078-1.423-.23l-3.114-1.04a4.501 
                            4.501 0 0 0-1.423-.23H5.904" />
                    </svg>
                    <span class="text-gray-600 font-medium">{{ $post->claps()->count() }}</span>
                    <span class="text-gray-400">Claps</span>
                </div>
            </div>
        </div>

        {{-- Image Section (Right Side) --}}
        <div class="sm:w-48 w-full h-48 sm:h-auto overflow-hidden bg-gray-100">
            <img 
                src="{{ $post->imageUrl() ?? asset('images/default-post.jpg') }}" 
                alt="Post Image" 
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
            />
        </div>
    </div>
</div>
