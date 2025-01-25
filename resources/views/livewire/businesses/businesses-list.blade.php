<div class="p-6">
    <!-- Hero Section -->
    <div class="py-8">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold text-gray-800">Top-Rated Businesses</h1>
            <p class="mt-4 text-lg text-gray-600">
                Search and explore businesses by name, location, or category.
            </p>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white py-6 shadow-md">
        <div class="container mx-auto grid grid-cols-1 sm:grid-cols-3 gap-6">
            <!-- Search by Name -->
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name..."
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">

            <!-- Search by Location -->
            <input type="text" wire:model.live.debounce.300ms="location" placeholder="Search by location..."
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">

            <!-- Search by Category -->
            <input list="categories" wire:model.live.debounce.300ms="category" placeholder="Search by Category..."
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
            <datalist id="categories" class="">
                <option value="All Categories"></option>
                @foreach ($categories as $category)
                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                @endforeach
            </datalist>
        </div>
    </div>




    <!-- Business List Section -->
    <div class="container mx-auto py-10">
        <div class="text-gray-600 text-sm mb-4">
            @if ($search || $location || $currentCat)
                <p>
                    Showing results for:
                    @if ($currentCat)
                        <strong>"{{ $currentCat?->name }}"</strong>
                    @endif
                    @if ($location)
                        in <strong>"{{ $location }}"</strong>
                    @endif
                    @if ($search)
                        by <strong>"{{ $search }}"</strong>
                    @endif

                    <a wire:click='clearFilters' class="ml-4 underline cursor-pointer">Clear Filters</a>
                </p>
            @endif
        </div>
        @if ($businesses->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($businesses as $business)
                    <div wire:key="item-{{ $business->id }}"
                        class="mx-1 bg-white border border-gray-200 rounded-lg shadow-lg transform transition-transform hover:scale-105 dark:bg-gray-800 dark:border-gray-700">
                        <!-- Business Logo -->
                        <a href="{{ route('businesses.show', $business->slug) }}">
                            <img src="{{ $business->business_logo ? asset('storage/' . $business->business_logo) : asset('default-business-logo.png') }}"
                                alt="{{ $business->name }} Logo" class="rounded-t-lg w-full h-40 object-cover">
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
                            <p class="mb-4 text-sm font-medium text-gray-700 dark:text-gray-400 truncate">
                                {{ $business->category->name }}
                            </p>

                            <!-- Business Location -->
                            <p class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-400 truncate">
                                <i class="fa fa-location-dot"></i> {{ $business->location }}
                            </p>

                            <!-- Review Stars -->
                            {{-- @livewire('review-stars', ['entity' => $business]) --}}

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
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-button rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-900">
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
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-10 text-center">
                {{ $businesses->links() }}
            </div>
        @else
            <!-- No Results Found -->
            <div class="text-center py-20">
                <h3 class="text-2xl font-bold text-gray-700">No businesses found</h3>
                <p class="text-gray-600 mt-4">Try adjusting your search or filters.</p>
            </div>
        @endif
    </div>
</div>
