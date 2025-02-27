<div>
    {{-- Business Page Header Start --}}
    @component('components.businesses.business-page-header', [
        'business' => $business,
        'ratingBreakdown' => $ratingBreakdown,
        'bgPicture' => $business->business_logo,
    ])
    @endcomponent
    {{-- Business Page Header End --}}

    <section class="container py-8 mx-auto" id="business-details">
        <!-- Tabs Container -->
        <div class="flex flex-wrap justify-center gap-2 ">
            <!-- Reviews Tab -->
            <button wire:click="switchTab('reviews')"
                class="flex-1 md:flex-none text-sm md:text-base font-medium px-4 py-2 rounded border-b-2 {{ $activeTab === 'reviews' ? 'border-b-2 border-yellow-500' : 'bg-white text-gray-800 border-gray-200 hover:bg-gray-100' }}">
                Reviews
            </button>

            <!-- About Tab -->
            <button wire:click="switchTab('about')"
                class="flex-1 md:flex-none text-sm md:text-base font-medium px-4 py-2 rounded border-b-2 {{ $activeTab === 'about' ? 'border-b-2 border-yellow-500' : 'bg-white text-gray-800 border-gray-200 hover:bg-gray-100' }}">
                About
            </button>

            <!-- Contact Tab -->
            <button wire:click="switchTab('contact')"
                class="flex-1 md:flex-none text-sm md:text-base font-medium px-4 py-2 rounded border-b-2 {{ $activeTab === 'contact' ? 'border-b-2 border-yellow-500' : 'bg-white text-gray-800 border-gray-200 hover:bg-gray-100' }}">
                Contact
            </button>

            <!-- Review Form Tab -->
            <button wire:click="switchTab('review-form')"
                class="flex-1 md:flex-none text-sm md:text-base font-medium px-4 py-2 rounded border-b-2 {{ $activeTab === 'review-form' ? 'border-b-2 border-yellow-500' : 'bg-white text-gray-800 border-gray-200 hover:bg-gray-100' }}">
                Write Review
            </button>
        </div>

        <!-- Tab Content -->
        <div class="mt-8 px-2">
            <!-- Reviews Section -->
            @if ($activeTab === 'reviews')
                <div wire:loading.class="animate-pulse">

                    <!-- Sorting Options -->
                    <div class="flex gap-2 mb-6">
                        <button wire:click="sortReviews('newest')"
                            class="px-4 py-2 text-sm font-medium rounded {{ $sortBy === 'newest' ? 'bg-orange-600 text-white' : 'bg-white text-gray-800 border border-gray-200 hover:bg-gray-100' }}">
                            Newest
                        </button>
                        <button wire:click="sortReviews('highest_rated')"
                            class="px-4 py-2 text-sm font-medium rounded {{ $sortBy === 'highest_rated' ? 'bg-orange-600 text-white' : 'bg-white text-gray-800 border border-gray-200 hover:bg-gray-100' }}">
                            Highest Rated
                        </button>
                        <button wire:click="sortReviews('lowest_rated')"
                            class="px-4 py-2 text-sm font-medium rounded {{ $sortBy === 'lowest_rated' ? 'bg-orange-600 text-white' : 'bg-white text-gray-800 border border-gray-200 hover:bg-gray-100' }}">
                            Lowest Rated
                        </button>
                    </div>

                    <!-- Review List -->
                    <div>
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
                <div class="mt-4">
                    <strong>Category:</strong>
                    <a href="{{ route('categoryPage', ['slug' => $business->category->slug]) }}"
                        class="text-orange-500">{{ $business->category->name }}</a>
                </div>
            @elseif ($activeTab === 'contact')
                <!-- Contact Content -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">Contact Details</h2>
                    <p>📍 {{ $business->location }}</p>
                    <div class="flex gap-5 mt-4">
                        <p>
                            @if ($business->contact_website)
                                <a href="{{ $business->contact_website }}" target="_blank">
                                    <i class="fas fa-globe"></i> Visit Now
                                </a>
                            @endif
                        </p>
                        <p>
                            @if ($business->contact_phone)
                                <a href="tel:{{ $business->contact_phone }}" class="btn btn-outline-success w-100">
                                    📞 {{ $business->contact_phone }}
                                </a>
                            @endif
                        </p>
                        <p>
                            @if ($business->contact_email)
                                <a href="mailto:{{ $business->contact_email }}" class="">
                                    <i class="fas fa-envelope"></i> Email
                                </a>
                            @endif
                        </p>
                    </div>
                </div>
                {{-- @include('components.contact-info', ['entity' => $business]) --}}
            @elseif ($activeTab === 'review-form')
                <div>
                    <h2 class="text-2xl font-bold mb-4">Write a Review</h2>
                    <!-- Review Form -->
                    <form wire:submit.prevent="submitReview">
                        <!-- Rating -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                            <div class="flex space-x-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <button type="button" wire:click="$set('rating', {{ $i }})"
                                        class="text-2xl {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}">
                                        <i class="star fa fa-star rev-star" data-value="1"></i>
                                    </button>
                                @endfor
                            </div>
                            @error('rating')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Comment -->
                        <div class="mb-6">
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Comment</label>
                            <textarea wire:model="comment" id="comment" rows="5"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-primary-600"
                                placeholder="Share your experience..."></textarea>
                            @error('comment')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        @auth
                            <input type="hidden" wire:model="reviewer_id">
                        @endauth
                        <!-- Guest Fields -->
                        @guest
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- Name -->
                                <div>
                                    <label for="reviewer_name" class="block text-sm font-medium text-gray-700 mb-2">Your
                                        Name</label>
                                    <input wire:model="reviewer_name" type="text" id="reviewer_name"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-primary-600">
                                    @error('reviewer_name')
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="reviewer_email" class="block text-sm font-medium text-gray-700 mb-2">Your
                                        Email</label>
                                    <input wire:model="reviewer_email" type="email" id="reviewer_email"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-primary-600">
                                    @error('reviewer_email')
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- CAPTCHA -->
                            {{-- <div class="mb-6">
                                <div wire:ignore>

                                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}">
                                    </div>
                                </div>
                                @error('recaptcha')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div> --}}
                        @endguest

                        <!-- Submit Button -->
                        <button type="submit"
                            class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-primary-300">
                            Submit Review
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </section>
</div>
