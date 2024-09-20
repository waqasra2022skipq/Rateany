<div class="container my-5">
    <h2 class="text-center mb-4">Top Restaurants</h2>
    <div class="row">
        @foreach ($topRestaurants as $restaurant)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $restaurant->image_url ? asset($restaurant->image_url) : asset('images/default-restaurant.jpg') }}"
                        class="card-img-top" alt="{{ $restaurant->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $restaurant->name }}</h5>
                        <p class="card-text">
                            <strong>Rating:</strong> {{ number_format($restaurant->average_rating, 1) }}/5
                        </p>
                        <p class="card-text">
                            {{ Str::limit($restaurant->description, 100) }}
                        </p>
                        <a href="{{ route('businesses.show', $restaurant->id) }}" class="btn btn-primary">
                            View Restaurant
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
