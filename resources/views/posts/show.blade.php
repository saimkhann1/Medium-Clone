<x-app-layout>
    <div class="py-8 bg-gray-50">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-200">
                <div class="p-8 text-gray-900">

                    {{-- 📝 Post Title --}}
                    <h1 class="text-4xl md:text-5xl font-extrabold mb-6 text-gray-900 tracking-tight">
                        {{ $post->title }}
                    </h1>

                    {{-- 👤 Author Info --}}
                    <div class="flex items-start gap-4 mb-6">
                        {{-- Avatar --}}
                        <x-user-avatar :user="$post->user" class="w-14 h-14"/>

                        <div class="flex-1">
                            {{-- Name + Follow --}}
                            <div class="flex items-center gap-3">
                                <a href="{{ route('profile.show', $post->user) }}"
                                    class="hover:underline font-semibold text-gray-900 text-base">
                                    {{ $post->user->name }}
                                </a>

                                {{-- ✅ Follow/Unfollow --}}
                                @if (auth()->check() && auth()->id() !== $post->user->id)
                                    <div x-data="{
                                        following: {{ $post->user->isFollowedBy(auth()->user()) ? 'true' : 'false' }},
                                        async toggleFollow() {
                                            this.following = !this.following;
                                            try {
                                                const response = await axios.post(`/follow/{{ $post->user->id }}`, {}, {
                                                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
                                                });
                                                console.log(response.data);
                                            } catch (error) {
                                                console.error(error);
                                            }
                                        }
                                    }">
                                        <button @click="toggleFollow()"
                                            class="px-3 py-1 text-sm font-medium rounded-full transition-colors duration-200"
                                            :class="following ? 'bg-red-100 text-red-600 hover:bg-red-200' : 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200'"
                                            x-text="following ? 'Unfollow' : 'Follow'">
                                        </button>
                                    </div>
                                @endif
                            </div>

                            {{-- Date + Read Time --}}
                            <div class="text-gray-500 text-sm mt-1">
                                {{ $post->readTime() }} min read &middot; {{ $post->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>

                    {{-- ✏️ Edit/Delete buttons (only for post owner) --}}
                    @if ($post->user_id === auth()->id())
                        <div class="py-4 mt-6 border-t border-gray-200 flex gap-3">
                            <x-delete-btn-popup :action="route('post.destroy', $post)" class="bg-red-600 hover:bg-red-700 text-white"/>
                            <x-primary-button href="{{ route('post.edit', $post) }}" class="bg-blue-600 hover:bg-blue-700 text-white">
                                Edit Post
                            </x-primary-button>
                        </div>
                    @endif

                    {{-- 👏 Clap Button (Top) --}}
                      <div class="mt-6">
                        <x-clap-button :post="$post" />
                    </div>

                    {{-- 🖼️ Post Image --}}
                    @php
                        $imageUrl = $post->imageUrl();
                        $hasImage = $imageUrl && !Str::contains($imageUrl, 'default.jpg');
                    @endphp

                    @if ($hasImage)
                        <div class="my-6">
                            <img src="{{ $imageUrl }}" alt="{{ $post->title }}"
                                class="w-full rounded-2xl h-80 md:h-96 object-cover border border-gray-200 shadow-md transition-transform duration-300 hover:scale-105">
                        </div>
                    @endif

                    {{-- 📝 Post Content --}}
                    <div class="text-gray-700 text-lg leading-relaxed space-y-6 prose prose-indigo max-w-full">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    {{-- 🏷️ Category --}}
                    @if ($post->category)
                        <div class="mt-8">
                            <span class="inline-block px-4 py-2 rounded-full bg-indigo-100 text-indigo-800 font-medium text-sm">
                                {{ $post->category->name }}
                            </span>
                        </div>
                    @endif

                    {{-- 👏 Clap Button (Bottom) --}}
                    {{-- <div class="mt-6">
                        <x-clap-button :post="$post" />
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
