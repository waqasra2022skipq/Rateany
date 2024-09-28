@php
    $starColor = 'success';
@endphp
<div class="container rounded">
    <div id="reviewCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        @foreach ($reviews as $key => $review)
            <div class="carousel-item @if ($key == 0) active @endif">
                <div class="hero-section text-center p-5">
                    <div class="review-card bg-light p-4 rounded shadow-sm">
                        <h3 class="mb-3 h-50">
                            <strong>{{ $review->reviewer->name }}</strong> rated
                            @if ($review->business_id)
                                <a href="{{ route('businesses.show', $review->business->id) }}"
                                    class="business-link">{{ $review->business->name }}</a>
                            @elseif ($review->user_id)
                                <a href="{{ route('user.show', $review->user->id) }}"
                                    class="user-link">{{ $review->user->name }}</a>
                            @endif
                            <br>
                            @switch($review->rating)
                                @case(1)
                                    @php
                                        $starColor = 'danger';
                                    @endphp
                                @break

                                @case(2)
                                    @php
                                        $starColor = 'warning';
                                    @endphp
                                @break

                                @case(3)
                                    @php
                                        $starColor = 'info';
                                    @endphp
                                @break

                                @case(4)
                                    @php
                                        $starColor = 'primary';
                                    @endphp
                                @break

                                @case(5)
                                    @php
                                        $starColor = 'success';
                                    @endphp
                                @break

                                @default
                            @endswitch
                            {{ $review->rating }}
                            @for ($i = 1; $i <= $review->rating; $i++)
                                <i class="star fa fa-star text-{{ $starColor }}"></i>
                            @endfor
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
</div>
