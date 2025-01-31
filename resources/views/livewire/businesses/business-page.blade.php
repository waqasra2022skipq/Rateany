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
            @if ($activeTab === 'reviews')
                <!-- Reviews Content -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">Customer Reviews</h2>
                    <!-- Display reviews here -->
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
