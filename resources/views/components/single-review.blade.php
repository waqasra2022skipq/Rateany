<div class="p-6 bg-white rounded-lg shadow-sm">
    <div class="flex items-center gap-4 mb-4">
        <!-- User Avatar -->
        {{-- <img src="{{ $review->user->avatar_url }}" alt="{{ $review->user->name }}" class="w-10 h-10 rounded-full"> --}}

        <!-- User Info -->
        <div>
            <h3 class="font-semibold">{{ $review->reviewer_name }}</h3>
            <div class="flex items-center gap-1">
                <!-- Star Rating -->
                @for ($i = 1; $i <= 5; $i++)
                    <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                        </path>
                    </svg>
                @endfor
            </div>
        </div>
    </div>

    <!-- Review Text -->
    <p class="text-gray-700 mb-4">{{ $review->comments }}</p>

    <!-- Review Metadata -->
    <div class="flex items-center justify-between text-sm text-gray-500">
        <time datetime="{{ $review->created_at->toIso8601String() }}">
            {{ $review->created_at->diffForHumans() }}
        </time>
        {{-- <div class="flex items-center gap-4">
            <button class="flex items-center gap-1 hover:text-gray-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5">
                    </path>
                </svg>
                <span>{{ $review->helpful_count }} Helpful</span>
            </button>
            <button class="hover:text-gray-700">Report</button>
        </div> --}}
    </div>
</div>
