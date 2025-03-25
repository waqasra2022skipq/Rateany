{{-- Latest Reviews --}}
<section class="p-10 bg-white">
    <div class="container mx-auto">
        <!-- Section Header -->
        <div class="text-center mb-10">
            <h2 class="text-4xl font-extrabold text-gray-800">Latest Customer Reviews</h2>
            <p class="mt-4 text-lg text-gray-600">
                See what customers are saying about top-rated businesses and professionals.
            </p>
        </div>

        <!-- Reviews Grid -->
        <div class="grid gap-6 md:gap-8 md:grid-cols-3 mb-8 rounded-lg shadow-sm bg-white dark:bg-gray-800 p-6">
            @foreach ($reviews as $review)
                <figure
                    class="flex flex-col items-center justify-center p-6 text-center bg-gray-50 border-b border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 business-card transform transition-transform hover:scale-105">
                    <!-- Review Content -->
                    <blockquote class="max-w-2xl mx-auto mb-4 text-gray-500 dark:text-gray-400">
                        <!-- Stars -->
                        <div class="mb-2">
                            @for ($i = 1; $i <= $review->rating; $i++)
                                <i class="fa fa-star text-primary-500"></i>
                            @endfor
                        </div>
                        <!-- Review Text -->
                        <p class="my-2 italic">"{{ Str::limit($review->comments, 125) }}"</p>
                    </blockquote>

                    <!-- Reviewer Info -->
                    <figcaption class="flex flex-col items-center justify-center mt-4">
                        <div class="text-left ms-3 rtl:text-right">
                            <div class="text-lg font-semibold text-gray-800 dark:text-white">
                                {{ $review->reviewer_name }}
                            </div>
                            <!-- Business Name -->
                            @if ($review->business)
                                <a href="{{ route('businesses.show', $review->business->slug) }}"
                                    class="text-primary-500 hover:underline text-sm font-medium mt-1">
                                    {{ $review->business->name }}
                                </a>
                            @endif
                        </div>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>
