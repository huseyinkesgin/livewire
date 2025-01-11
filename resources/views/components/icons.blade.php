@props(['name'])

<div class="inline-flex gap-0.5">
    @switch($name)
        @case('save')
            <div class="flex items-center justify-center w-10 h-10 bg-gray-100 border border-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5C3 3.89543 3.89543 3 5 3H16L21 8V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V5Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 3V8H15V3" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 13H17" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 17H17" />
                </svg>
            </div>
        @break

        @case('delete')
            <div class="flex items-center justify-center w-10 h-10 bg-gray-100 border border-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
        @break

        @case('clear')
            <div class="flex items-center justify-center w-10 h-10 bg-gray-100 border border-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </div>
        @break

        @case('close')
            <div class="flex items-center justify-center w-10 h-10 bg-gray-100 border border-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="red" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        @break

        @case('new')
            <div class="flex items-center justify-center w-10 h-10 bg-gray-100 border border-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                </svg>
            </div>
        @break

        @case('select')
            <div class="flex items-center justify-center w-10 h-10 bg-gray-100 border border-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        @break

        @case('refresh')
            <div class="flex items-center justify-center w-10 h-10 bg-gray-100 border border-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </div>
        @break
    @endswitch
</div>
