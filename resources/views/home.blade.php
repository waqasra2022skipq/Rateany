<x-layout>
    <div id="reviewCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($reviews as $key => $review)
                <div class="carousel-item @if ($key == 0) active @endif">
                    <div class="hero-section text-center p-5">
                        <h2 class="text-2xl font-bold mb-3">Latest Reviews</h2>
                        <div class="review-card bg-light p-4 rounded shadow-sm">
                            <h3 class="mb-3">
                                <strong>{{ $review->reviewer->name }}</strong> rated
                                @if ($review->business_id)
                                    <a href="{{ route('businesses.show', $review->business->id) }}"
                                        class="business-link">{{ $review->business->name }}</a>
                                @elseif ($review->user_id)
                                    <a href="{{ route('user.show', $review->user->id) }}"
                                        class="user-link">{{ $review->user->name }}</a>
                                @endif
                                {{ number_format($review->rating, 1) }}/5
                            </h3>
                            <p class="text-muted">{{ Str::limit($review->comments, 150) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#reviewCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#reviewCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    @include('components.top-restaurants-card', ['topRestaurants' => $topRestaurants])

</x-layout>
