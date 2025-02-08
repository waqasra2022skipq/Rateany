<div class="business-header"
    style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('storage/' . $bgPicture) }}');">
    <div class="container mx-auto px-4 py-8 text-white">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Column 1: Business Info -->
            <div class="flex flex-col justify-center text-center lg:text-left">
                <h1 class="text-4xl font-bold mb-2">{{ $business->name }}</h1>
                <p class="text-lg mb-4">{{ Str::limit($business->description ?? $business->bio, 250) }}</p>
                <div class="flex gap-4 justify-center lg:justify-start">
                    @if ($business->contact_website)
                        <a href="{{ $business->contact_website }}" target="_blank"
                            class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded">
                            Visit Now
                        </a>
                    @endif
                    <a href="#business-details" class="bg-orange-600 hover:bg-orange-800 text-white px-6 py-2 rounded"
                        wire:click="switchTab('review-form')">
                        Write Review
                    </a>
                </div>
            </div>

            <!-- Column 2: Rating Breakdown -->
            <div class="bg-white bg-opacity-10 p-6 rounded-lg">
                <div class="text-center">
                    <div class="mt-2">
                        <h2 class="text-4xl font-bold">
                            <strong>{{ number_format($business->average_rating, 1) }}</strong>
                        </h2>
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $business->average_rating)
                                <i class="fas fa-star text-yellow-500"></i>
                            @elseif($i - 0.5 <= $business->average_rating)
                                <i class="fas fa-star-half-alt text-yellow-500"></i>
                            @else
                                <i class="far fa-star text-yellow-500"></i>
                            @endif
                        @endfor
                        <p>{{ $business->reviews_count }} Reviews</p>

                    </div>
                </div>
                @foreach ([5, 4, 3, 2, 1] as $rating)
                    <div class="flex items-center mb-2"
                        title='{{ $rating }}-star {{ $business->{"${rating}_star_count"} }} reviews'>
                        <span class="w-8">{{ $rating }}</span>
                        <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                            <div class="bg-yellow-400 text-xs font-medium text-black text-center p-0.5 leading-none rounded-full"
                                style="width: {{ $ratingBreakdown[$rating] }}%;">
                                {{ number_format($ratingBreakdown[$rating], 1) }}%</div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
