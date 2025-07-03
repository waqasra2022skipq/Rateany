<div class="container py-10 mx-auto px-5">
    <!-- Review Form -->
    <form wire:submit.prevent="generateAIReview">
        <!-- Business Information (if not found) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Name <b class="text-red-500">*</b></label>
                <input wire:model="business_name" autocomplete="business_name" type="text"
                    placeholder="Enter the name of business,product or professional"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('business_name')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Category <b
                        class="text-red-500">*</b></label>

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
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Address(optional)</label>
            <input wire:model="business_location" type="text" placeholder="Enter the address of the business"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('business_location')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Website(optional)</label>
                <input wire:model="contact_website" type="text"
                    placeholder="Enter the link of the business, product or professional"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('contact_website')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>




        <!-- Submit Button -->
        <button type="submit"
            class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-primary-300">
            Generate AI Review
        </button>
    </form>

    <!-- Latest AI Reviews -->
    <div class="mt-10">
        <h2 class="text-xl font-bold mb-4">Latest AI Reviews</h2>
        @if (isset($latestAIReviews) && count($latestAIReviews))
            <div class="space-y-6">
                @foreach ($latestAIReviews as $aiReview)
                    <div class="p-4 border rounded shadow-sm bg-gray-50">
                        <div class="font-semibold">
                            @if ($aiReview?->business?->slug)
                                <a href="{{ route('businesses.show', ['slug' => $aiReview?->business?->slug]) }}"
                                    class="text-blue-600">
                                    {{ $aiReview->business->name ?? 'Business' }}
                                </a>
                            @endif

                        </div>
                        <div class="text-sm text-gray-600 mb-2">
                            {{ $aiReview->business->category->name ?? '' }} | {{ $aiReview->business->location ?? '' }}
                        </div>
                        <div class="prose max-w-none">{!! nl2br(e($aiReview->ai_summary)) !!}</div>
                        <div class="text-xs text-gray-400 mt-2">
                            {{ $aiReview->created_at?->diffForHumans() }}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No AI reviews yet.</p>
        @endif
    </div>
</div>
