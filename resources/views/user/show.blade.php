<x-layout>
    <div class="container my-4">
        <div class="row">
            <!-- User Profile Section -->
            @include('user.header', ['user' => $user])

            <div class="mt-5">
                @include('components.write-review', ['user_id' => $user->id])
            </div>

            <!-- Reviews Section -->
            <div class="mt-5">
                <h3>Reviews by People</h3>

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


        <!-- Businesses Section -->
        <div class="d-flex justify-content-between mb-4">
            <h3>Businesses</h3>
        </div>

        <div class="row">
            @foreach ($businesses as $business)
                @include('components.business-card', ['business' => $business])
            @endforeach
        </div>

        <!-- Pagination -->
        {{-- <div class="d-flex justify-content-center">
            {{ $businesses->links() }}
        </div> --}}
    </div>
</x-layout>
