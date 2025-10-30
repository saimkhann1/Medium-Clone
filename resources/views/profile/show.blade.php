<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div 
                    class="flex"
                    x-data="{ following: {{ $user->isFollowedBy(auth()->user()) ? 'true' : 'false' }} ,
                    followersCount: {{ $user->followers()->count() }} ,
                        follow(){
                            this.following=!this.following
                            axios.post('/follow/{{$user->id}}').then
                            (response=>{
                                console.log(response.data)  
                                this.followersCount = response.data.followersCount
                            })
                                .catch(err=>{
                                console.log(err)
                                })
                        }
                    }">

                    <!-- Left side: Posts -->
                    <div class="flex-1">
                        <h1 class="text-5xl">{{ $user->name }}</h1>
                        <div class="mt-8">
                            @forelse($posts as $post)
                                <x-post-item :post="$post" />
                            @empty
                                <div>
                                    <p class="text-gray-900 text-center text-2xl">No posts found!!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Right side: Profile card -->
                    <div class="w-[320px] border-1 px-8">
                        <x-user-avatar :user="$user" size="w-16 h-16" />
                        <h3 class="text-xl font-semibold mt-2">{{ $user->name }}</h3>
                        <p class="text-gray-500"><span x-text="followersCount"></span> Followers</p>
                        <p class="text-gray-700">{{ $user->bio }}</p>

                        <!-- Follow/Unfollow button -->
                        <div class="mt-3">
                            @if(auth()->check() && auth()->id() !== $user->id)
                                
                                <button 
                                    @click="follow()"
                                    class="rounded-full px-4 py-2 text-white font-semibold transition"
                                    x-text="following ? 'Unfollow' : 'Follow'"
                                    :class="following ? 'bg-red-500' : 'bg-emerald-500'">
                                    Follow
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
