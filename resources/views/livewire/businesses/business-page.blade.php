<div>
    {{-- Business Page Header Start --}}
    @component('components.businesses.business-page-header', [
        'business' => $business,
        'ratingBreakdown' => $ratingBreakdown,
    ])
    @endcomponent
    {{-- Business Page Header End --}}


    <section class="p-10">
        <!-- Tabs Container -->
        <div class="flex flex-wrap justify-center gap-2 ">
            <!-- Reviews Tab -->
            <button wire:click="switchTab('reviews')"
                class="flex-1 md:flex-none text-sm md:text-base font-medium px-4 py-2 rounded border-b-2 {{ $activeTab === 'reviews' ? 'border-b-2 border-blue-500' : 'bg-white text-gray-800 border-gray-200 hover:bg-gray-100' }}">
                Reviews
            </button>

            <!-- About Tab -->
            <button wire:click="switchTab('about')"
                class="flex-1 md:flex-none text-sm md:text-base font-medium px-4 py-2 rounded border-b-2 {{ $activeTab === 'about' ? 'border-b-2 border-blue-500' : 'bg-white text-gray-800 border-gray-200 hover:bg-gray-100' }}">
                About
            </button>

            <!-- Contact Tab -->
            <button wire:click="switchTab('contact')"
                class="flex-1 md:flex-none text-sm md:text-base font-medium px-4 py-2 rounded border-b-2 {{ $activeTab === 'contact' ? 'border-b-2 border-blue-500' : 'bg-white text-gray-800 border-gray-200 hover:bg-gray-100' }}">
                Contact
            </button>

            <!-- Review Form Tab -->
            <button wire:click="switchTab('review-form')"
                class="flex-1 md:flex-none text-sm md:text-base font-medium px-4 py-2 rounded border-b-2 {{ $activeTab === 'review-form' ? 'border-b-2 border-blue-500' : 'bg-white text-gray-800 border-gray-200 hover:bg-gray-100' }}">
                Write Review
            </button>
        </div>

        <!-- Tab Content -->
        <div class="mt-8 p-10">
            <!-- Reviews Section -->
            @if ($activeTab === 'reviews')
                <div>
                    <!-- Sorting Options -->
                    <div class="flex flex-wrap gap-4 mb-6">
                        <button wire:click="sortReviews('newest')"
                            class="px-4 py-2 text-sm font-medium rounded {{ $sortBy === 'newest' ? 'bg-gray-900 text-white' : 'bg-white text-gray-800 border border-gray-200 hover:bg-gray-100' }}">
                            Newest
                        </button>
                        <button wire:click="sortReviews('highest_rated')"
                            class="px-4 py-2 text-sm font-medium rounded {{ $sortBy === 'highest_rated' ? 'bg-gray-900 text-white' : 'bg-white text-gray-800 border border-gray-200 hover:bg-gray-100' }}">
                            Highest Rated
                        </button>
                        <button wire:click="sortReviews('most_helpful')"
                            class="px-4 py-2 text-sm font-medium rounded {{ $sortBy === 'most_helpful' ? 'bg-gray-900 text-white' : 'bg-white text-gray-800 border border-gray-200 hover:bg-gray-100' }}">
                            Most Helpful
                        </button>
                    </div>

                    <!-- Review List -->
                    <div
                        class="space-y-6 grid gap-6 md:gap-8 md:grid-cols-3 mb-8 rounded-lg shadow-sm  bg-white dark:bg-gray-800 p-6">
                        @foreach ($reviews as $review)
                            @component('components.single-review', ['review' => $review])
                            @endcomponent
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $reviews->links() }}
                    </div>
                </div>
            @elseif ($activeTab === 'about')
                <!-- About Content -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">About {{ $business->name }}</h2>
                    <p>{{ $business->description }}</p>
                </div>
            @elseif ($activeTab === 'contact')
                <!-- Contact Content -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">Contact Details</h2>
                    <p>📍 {{ $business->location }}</p>
                    <p>📞 {{ $business->phone }}</p>
                    <p>✉️ {{ $business->email }}</p>
                </div>
            @elseif ($activeTab === 'review-form')
                <!-- Review Form Content -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">Write a Review</h2>
                    <!-- Add review form here -->
                </div>
            @endif
        </div>
    </section>
</div>
