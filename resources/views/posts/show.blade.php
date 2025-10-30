<x-app-layout>
    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Post Title --}}
                    <h1 class="text-3xl font-semibold mb-4">{{ $post->title }}</h1>

                    {{-- Author Info --}}
                    <div class="flex items-start gap-3 mb-4">
                        {{-- User Avatar --}}
                        <x-user-avatar :user="$post->user" />

                        {{-- User Info --}}
                        <div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('profile.show', $post->user) }}" class="hover:underline font-semibold text-gray-900 text-sm">
                                    {{ $post->user->name }}
                                </a>

                                {{-- Dynamic Follow/Unfollow Button --}}
                                <div 
                                    x-data="{
                                        following: {{ $post->user->isFollowedBy(auth()->user()) ? 'true' : 'false' }},
                                        follow() {
                                            this.following = !this.following;
                                            axios.post(`/follow/{{ $post->user->id }}`, {}, {
                                                headers: {
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                                }
                                            })
                                            .then(response => console.log(response.data))
                                            .catch(error => console.error(error));
                                        }
                                    }"
                                >
                                    @if(auth()->check() && auth()->id() !== $post->user->id)
                                        <button 
                                            @click="follow()"
                                            class="text-sm font-medium transition"
                                            :class="following ? 'text-red-500 hover:text-red-700' : 'text-emerald-500 hover:text-emerald-700'"
                                            x-text="following ? 'Unfollow' : 'Follow'">
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="text-gray-500 text-xs mt-1">
                                {{ $post->readTime() }} min read
                                &middot;
                                {{ $post->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                    @if($post->user_id === auth()->id())
                    <div class="py-6 mt-4 border-t border-gray-200">
                        <form class="inline-block" action="{{route('post.destroy',$post)}} " method="POST">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Delete Post</x-danger-button>
                        </form>
                        <x-primary-button href="{{ route('post.edit', $post) }}">Edit Post</x-primary-button>
                    </div>
                    @endif
                    {{-- ✅ First clap button --}}
                    <x-clap-button :post="$post" />

                    {{-- Post Image --}}
                    @if ($post->image)
                        <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-full rounded-lg mb-4 h-70 mt-6">
                    @endif

                    {{-- Post Content --}}
                    <div class="text-gray-800 leading-relaxed"> 
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    <div class="mt-8">
                        <span class="px-4 py-2 rounded-2xl bg-gray-200">{{ $post->category->name }}</span>
                    </div>

                    {{-- ✅ Second clap button (fixed) --}}
                    <x-clap-button :post="$post" />

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
