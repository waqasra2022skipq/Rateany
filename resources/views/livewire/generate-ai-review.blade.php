<div class="container py-10 mx-auto px-5">
    <!-- SEO Headings and Intro -->
    <header class="mb-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">
            AI Review Generator for Businesses, Products & Professionals
        </h1>
        <p class="text-lg text-gray-700">
            Instantly generate unbiased, AI-powered reviews for any business, product, or professional. Discover the latest AI-generated reviews below or create a new one for your favorite (or least favorite) service!
        </p>
    </header>

    <!-- Review Form -->
    <section aria-label="Generate a New AI Review" class="mb-12">
        <h2 class="text-2xl font-bold mb-4">Generate a New AI Review</h2>
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
    </section>

    <!-- Latest AI Reviews -->
    <section aria-label="Latest AI Reviews" class="mt-10">
        <h2 class="text-2xl font-bold mb-4">Latest AI-Generated Business Reviews</h2>
        <p class="mb-6 text-gray-700">
            Explore the most recent AI-generated reviews for businesses and professionals across various categories. Each review is crafted by our advanced AI to provide a quick, unbiased summary of public sentiment.
        </p>
        @if (isset($latestAIReviews) && count($latestAIReviews))
            <div class="space-y-6">
                @foreach ($latestAIReviews as $aiReview)
                    <article class="p-4 border rounded shadow-sm bg-gray-50" itemscope itemtype="https://schema.org/Review">
                        <meta itemprop="itemReviewed" content="{{ $aiReview->business->name ?? 'Business' }}">
                        <header>
                            <h3 class="font-semibold text-lg" itemprop="name">
                                @if ($aiReview?->business?->slug)
                                    <a href="{{ route('businesses.show', ['slug' => $aiReview?->business?->slug]) }}"
                                        class="text-blue-600" itemprop="url">
                                        {{ $aiReview->business->name ?? 'Business' }}
                                    </a>
                                @else
                                    {{ $aiReview->business->name ?? 'Business' }}
                                @endif
                            </h3>
                            <div class="text-sm text-gray-600 mb-2" itemprop="itemReviewed" itemscope itemtype="https://schema.org/LocalBusiness">
                                <span itemprop="name">{{ $aiReview->business->name ?? '' }}</span>
                                @if($aiReview->business?->category)
                                    <span> | <span itemprop="category">{{ $aiReview->business->category->name }}</span></span>
                                @endif
                                @if($aiReview->business?->location)
                                    <span> | <span itemprop="address">{{ $aiReview->business->location }}</span></span>
                                @endif
                            </div>
                        </header>
                        <div class="prose max-w-none mb-2" itemprop="reviewBody">{!! nl2br(e($aiReview->ai_summary)) !!}</div>
                        <div class="text-xs text-gray-400 mt-2">
                            <time itemprop="datePublished" datetime="{{ $aiReview->created_at?->toDateString() }}">
                                {{ $aiReview->created_at?->diffForHumans() }}
                            </time>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No AI reviews yet. Be the first to generate one!</p>
        @endif
    </section>
</div>

@push('meta')
    <meta property="og:title" content="AI Review Generator for Businesses, Products & Professionals | RateAny" />
    <meta property="og:description" content="Generate and explore the latest AI-powered reviews for businesses, products, and professionals. Instantly create unbiased summaries and discover trending opinions." />
    <meta name="keywords" content="AI reviews, business reviews, generate review, product review, professional review, unbiased reviews, RateAny" />
@endpush
