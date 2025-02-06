<section class="p-10 bg-gray-50" id="top-rated-section">
    <div class="container mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-4xl font-extrabold text-gray-800">Top Rated Businesses</h2>
            <p class="mt-4 text-lg text-gray-600">
                Discover the most loved and highly rated businesses around you, trusted by thousands of customers.
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Right: Top Rated Businesses -->
            <div class="md:col-span-2 order-1 md:order-none">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-10" wire:loading.class="opacity-50">
                    @forelse ($topBusinesses as $business)
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
                                            ({{ $business->reviews_count }})
                                        </strong>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="mt-4">
                                    <a href="{{ route('businesses.show', $business->slug) }}"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-button rounded-lg  focus:outline-none focus:ring-2 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-900">
                                        View
                                        <svg class="w-4 h-4 ms-2 rtl:rotate-180" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center col-span-3">No Businesses Found, Try adjusting the category, or hit below
                            button to explore all businesses</p>
                    @endforelse
                </div>
                <!-- Browse All Businesses Button -->
                <div class="mt-10 text-center">
                    <a href="{{ route('allBusinesses') }}"
                        class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-button rounded-lg shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-300">
                        Browse More
                    </a>
                </div>
            </div>
            <!-- Left: Top Rated Categories -->
            <div class="p-6 order-2 md:order-none flex justify-center">
                <div class="w-full text-center">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Top Categories</h3>
                    <ul class="space-y-1">
                        @foreach ($categories as $category)
                            @if ($loop->index < 10)
                                <li>
                                    <a href="#top-rated-section" wire:click="updateCategory({{ $category->id }})"
                                        class="text-orange-600 hover:underline font-medium cursor-pointer">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <div class="mt-5">
                        <a href="{{ route('categories') }}"
                            class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-button rounded-lg shadow-lg  focus:outline-none focus:ring-4 focus:ring-blue-300">
                            Explore All Categories
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
