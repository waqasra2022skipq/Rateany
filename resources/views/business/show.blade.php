<x-layout>
    <div class="container my-4">
        <div class="row">
            <!-- Business Logo and Details -->
            <div class="col-md-4 d-flex align-items-center">
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
                    <p>Owned by: <strong>
                            <a href="{{ route('user.show', $business->owner->username) }}"
                                class="user-link">{{ $business->owner->name }}</a></strong></p>
                    <h2>Category</h2>
                    <p><strong>
                            <a href="{{ route('allBusinesses', ['category' => $business->category->slug]) }}"
                                class="business-link">{{ $business->category->name }}</a>
                        </strong>
                    </p>
                    <strong>Location:</strong>
                    <span>{{ $business->location }}</span>
                </div>
            </div>

            @include('components.reviews-bar', ['entity' => $business])

            <!-- Edit/Delete Buttons or Write Review -->
            <div class="col-md-2">
                @if (auth()->check() && auth()->user()->id == $business->owner->id)
                    <a href="{{ route('businesses.edit', $business->id) }}" class="btn btn-primary btn">Update
                        Business</a>
                @endif
            </div>
        </div>

        <div class="mt-5">
            @include('components.write-review', ['business_id' => $business->id])
        </div>

        <!-- Reviews Section -->
        <div class="mt-5">
            <h3>Customer Reviews</h3>

            @if ($reviews->count() > 0)
                @foreach ($reviews as $review)
                    @include('components.review-card', ['review' => $review])
                @endforeach

                <!-- Pagination Links -->
                <div class="d-flex justify-content-center">
                    {{ $reviews->withQueryString()->links() }}
                </div>
            @else
                <p>No reviews yet for this business.</p>
            @endif
        </div>
    </div>
</x-layout>
