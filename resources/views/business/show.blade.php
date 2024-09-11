<x-layout>
    <div class="container my-4">
        <div class="row">
            <!-- Business Logo and Details -->
            <div class="col-md-8 d-flex align-items-center">
                <div>
                    @if ($business->business_logo)
                        <img src="{{ asset('storage/' . $business->business_logo) }}" alt="Business Logo" class="rounded"
                            width="150" height="150">
                    @else
                        <img src="{{ asset('default-business-logo.png') }}" alt="Default Logo" class="rounded"
                            width="150" height="150">
                    @endif
                </div>
                <div class="ms-3">
                    <h2>{{ $business->name }}</h2>
                    <p>Owned by: <strong>{{ $business->owner->name }}</strong></p>
                </div>
            </div>

            <!-- Rating and Reviews -->
            <div class="col-md-4 text-end">
                <div class="bg-light p-3 rounded">
                    <h4>Rating: <strong>{{ $averageRating }}</strong></h4>
                    <p>Based on {{ $reviews->total() }} Reviews</p>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-5">
            <h3>Customer Reviews</h3>

            @if ($reviews->count() > 0)
                @foreach ($reviews as $review)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $review->reviewer->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $review->created_at->format('F j, Y') }}</h6>
                            <div class="mb-2">
                                <strong>Rating:</strong> {{ $review->rating }}/5
                            </div>
                            <p class="card-text">{{ $review->comments }}</p>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination Links -->
                <div class="d-flex justify-content-center">
                    {{ $reviews->links() }}
                </div>
            @else
                <p>No reviews yet for this business.</p>
            @endif
        </div>
    </div>
</x-layout>
