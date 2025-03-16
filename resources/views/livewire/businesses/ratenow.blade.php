<div class="container mx-auto py-10">
    <!-- Review Form -->
    <form wire:submit.prevent="submitReview">
        <!-- Business Information (if not found) -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Name <b class="text-red-500">*</b></label>
            <input wire:model="business_name" type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('business_name')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Category <b class="text-red-500">*</b></label>

            <!-- Search by Category -->
            <input list="categories" wire:model="business_category" placeholder="Select Category"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
            <datalist id="categories" class="">
                <option value="All Categories"></option>
                @foreach ($categories as $category)
                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                @endforeach
            </datalist>
            @error('business_category')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
            <input wire:model="business_location" type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('business_location')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                <input wire:model="contact_phone" type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('contact_phone')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                <input wire:model="contact_phone" type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('contact_phone')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>

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
            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Comment <b
                    class="text-red-500">*</b></label>
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
                        Name <b class="text-red-500">*</b></label>
                    <input wire:model="reviewer_name" type="text" id="reviewer_name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-primary-600">
                    @error('reviewer_name')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="reviewer_email" class="block text-sm font-medium text-gray-700 mb-2">Your
                        Email <b class="text-red-500">*</b></label>
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
