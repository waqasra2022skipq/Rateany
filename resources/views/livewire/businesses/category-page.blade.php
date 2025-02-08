<div class="p-10">
    <!-- Hero Section -->
    <div class="py-8">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold text-gray-800">{{ $category->name }}</h1>
            <p class="mt-4 text-lg text-gray-600">{{ $metaDescription }}</p>
        </div>
    </div>

    <!-- All Businesses Section -->
    <section class="py-10 bg-white">
        <div class="container mx-auto">
            <div class="flex flex-col sm:flex-row items-center gap-4 mb-6">
                <input type="text" wire:model="search" wire:input='$refresh' placeholder="Search by name..."
                    class="w-full sm:w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
                <input type="text" wire:model="location" wire:input='$refresh' placeholder="Search by location..."
                    class="w-full sm:w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 gap-6">
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

                            <!-- Business Location -->
                            <p class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-400 truncate">
                                {{ $business->location }}
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
                                        ({{ $business->reviews_count }})</strong>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <div class="mt-4">
                                <a href="{{ route('businesses.show', $business->slug) }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-900">
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
            <div class="mt-10 text-center">
                {{ $businesses->links() }}
            </div>

        </div>
    </section>

    <!-- Related Categories Section -->
    <section class="py-10 bg-gray-50">
        <div class="container mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Related Categories</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 gap-6">
                @foreach ($relatedCategories as $related)
                    <a href="{{ route('categoryPage', $related->slug) }}"
                        class="flex flex-col items-center p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
                        <div
                            class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-tag"></i>
                        </div>
                        <h3 class="text-sm font-medium text-gray-800 text-center">
                            {{ $related->name }}
                        </h3>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</div>
