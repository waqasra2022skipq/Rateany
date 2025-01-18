<div wire:key="item-{{ $business->id }}"
    class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-lg transform transition-transform hover:scale-105 dark:bg-gray-800 dark:border-gray-700">
    <!-- Business Logo -->
    <a href="{{ route('businesses.show', $business->slug) }}">
        <img src="{{ $business->business_logo ? asset('storage/' . $business->business_logo) : asset('default-business-logo.png') }}"
            alt="{{ $business->name }} Logo" class="rounded-t-lg w-full h-20 object-cover">
    </a>

    <!-- Card Content -->
    <div class="p-5">
        <!-- Business Name -->
        <a href="{{ route('businesses.show', $business->slug) }}">
            <h5 class="mb-2 text-lg font-bold text-gray-900 dark:text-white truncate">
                {{ Str::limit($business->name, 25) }}
            </h5>
        </a>

        <!-- Business Category -->
        <a href="{{ route('categoryPage', ['slug' => $business->category->slug]) }}">
            <p class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-400 truncate">
                {{ $business->category->name }}
            </p>
        </a>

        <!-- Business Location -->
        <p class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-400 truncate">
            {{ $business->location }}
        </p>

        <div class="mt-5">
            <div class="mt-2">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $business->average_rating)
                        <i class="fas fa-star text-yellow-500"></i>
                    @elseif($i - 0.5 <= $business->average_rating)
                        <i class="fas fa-star-half-alt text-yellow-500"></i>
                    @else
                        <i class="far fa-star text-yellow-500"></i>
                    @endif
                @endfor
                <strong>{{ number_format($business->average_rating, 1) }}
                    ({{ $business->reviews_count }})</strong>
            </div>
        </div>

        <!-- Action Button -->
        <div class="mt-4">
            <a href="{{ route('businesses.show', $business->slug) }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-900">
                View
                <svg class="w-4 h-4 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
            </a>
        </div>
    </div>
</div>
