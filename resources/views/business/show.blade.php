<x-layout>
    <div class="container my-4">
        <div class="row">
            <!-- Business Logo and Details -->
            <div class="col-md-4 d-flex flex-column flex-md-row align-items-center">
                <div class="text-center text-md-start mb-3 mb-md-0">
                    @if ($business->business_logo)
                        <img src="{{ asset('storage/' . $business->business_logo) }}" alt="Business Logo" class="rounded"
                            style="width: 150px; height: 150px;">
                    @else
                        <img src="{{ asset('default-business-logo.png') }}" alt="Default Logo" class="rounded"
                            style="width: 150px; height: 150px;">
                    @endif
                </div>
                <div class="ms-md-3 text-center text-md-start">
                    <h2>{{ $business->name }}</h2>
                    <strong>Category:</strong>
                    <strong>
                        <a href="{{ route('allBusinesses', ['category' => $business->category->slug]) }}"
                            class="business-link">{{ $business->category->name }}</a>
                    </strong>
                    <br>
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
            <h4>Bio</h4>
            <p>{{ $business->description ?? 'No bio available.' }}</p>
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
                <p>No reviews yet for {{ $business->name }}.</p>
            @endif
        </div>
    </div>
    <!-- Structured Data for Google Rich Snippets -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "{{ $business->name }}",
      "address": "{{ $business->location }}",
      "url": "{{ url()->current() }}",
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "{{ number_format($business->average_rating, 1) }}",
        "reviewCount": "{{ $business->reviews_count }}"
      }
    }
    </script>
</x-layout>
