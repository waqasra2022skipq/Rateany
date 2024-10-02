<x-layout>
    <div class="container my-4">
        <!-- User Profile Section -->
        <div class="row">
            @include('user.header', ['user' => $user])
        </div>

        <!-- Businesses Section -->
        <div class="d-flex justify-content-between mb-4 mt-5">
            <h3>Your Businesses</h3>
            <a href="{{ route('businesses.create') }}" class="btn btn-success">Add New Business</a>
        </div>

        <div class="row">
            @foreach ($businesses as $business)
                @include('components.business-card', ['business' => $business])
            @endforeach
        </div>

        <!-- Reviews Section -->
        <div class="mt-5">
            <h3>Reviews You Got</h3>

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
