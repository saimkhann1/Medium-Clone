@props(['post'])

<div 
    x-data="{
        hasClapped: {{ auth()->check() && auth()->user()->hasClapped($post) ? 'true' : 'false' }},
        count: {{ $post->claps()->count() }},
        clap() {
            axios.post('/clap/{{ $post->id }}')
                .then(response => {
                    this.hasClapped = !this.hasClapped;
                    this.count = response.data.clapsCount;
                })
                .catch(error => console.error(error));
        }
    }"
    class="border-t border-gray-200 mt-2 pt-4"
>
    <div class="flex items-center gap-2 text-gray-500 hover:text-gray-900 pl-2">
        <button 
            @click="clap()" 
            class="flex items-center gap-2 cursor-pointer hover:text-gray-900 transition-all duration-200"
        >
            <template x-if="!hasClapped">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
                     viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 
                        0 0 1 2.861-2.4c.723-.384 1.35-.956 
                        1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 
                        0 0 1 .75-.75 2.25 2.25 0 0 1 
                        2.25 2.25c0 1.152-.26 2.243-.723 
                        3.218-.266.558.107 1.282.725 
                        1.282h3.126c1.026 0 1.945.694 
                        2.054 1.715.045.422.068.85.068 
                        1.285a11.95 11.95 0 0 1-2.649 
                        7.521c-.388.482-.987.729-1.605.729H13.48
                        c-.483 0-.964-.078-1.423-.23l-3.114-1.04
                        a4.501 4.501 0 0 0-1.423-.23H5.904" />
                </svg>
            </template>

            <template x-if="hasClapped">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     viewBox="0 0 24 24" fill="currentColor" 
                     class="w-6 h-6 text-gray-900">
                    <path
                        d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 
                        0 0 1 6 15.125c0-1.75.599-3.358 
                        1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 
                        1.212-.924a9.042 9.042 0 0 1 
                        2.861-2.4c.723-.384 1.35-.956 
                        1.653-1.715a4.498 4.498 0 0 0 
                        .322-1.672V2.75A.75.75 
                        0 0 1 15 2a2.25 2.25 0 0 1 
                        2.25 2.25c0 1.152-.26 2.243-.723 
                        3.218-.266.558.107 1.282.725 
                        1.282h3.126c1.026 0 1.945.694 
                        2.054 1.715.045.422.068.85.068 
                        1.285a11.95 11.95 0 0 1-2.649 
                        7.521c-.388.482-.987.729-1.605.729H14.23
                        c-.483 0-.964-.078-1.423-.23l-3.114-1.04
                        a4.501 4.501 0 0 0-1.423-.23h-.777Z" />
                </svg>
            </template>

            <span x-text="count" class="text-sm font-medium"></span>
        </button>
    </div>
</div>
