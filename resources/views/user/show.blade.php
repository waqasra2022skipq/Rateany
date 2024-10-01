<x-layout>
    <div class="container my-4">
        <div class="row">
            <!-- User Profile Section -->
            <div class="col-md-8 d-flex align-items-center">
                <div>
                    @if ($user->profile_pic)
                        <img src="{{ asset('storage/' . $user->profile_pic) }}" alt="user Logo" class="rounded"
                            width="150" height="150">
                    @else
                        <img src="{{ asset('default-user-logo.png') }}" alt="Default User Logo" class="rounded"
                            width="150" height="150">
                    @endif
                </div>
                <div class="ms-3">
                    <h2>{{ $user->name }}</h2>
                    <p class="text-muted">{{ $user->email }}</p>
                    @if ($user->profession)
                        <h2>Profession</h2>
                        <p><strong>
                                <a href="{{ route('allUsers', ['profession' => $user->profession->id]) }}"
                                    class="business-link">{{ $user->profession->name }}</a>
                            </strong>
                        </p>
                    @endif
                </div>

            </div>
            <div class="col-md-4 text-end">
                <div class="bg-light p-3 rounded">
                    <h4>Rating: <strong>{{ number_format($user->average_rating, 1) }}</strong></h4>
                    <p>Based on {{ $user->reviews_count }} Reviews</p>
                </div>
            </div>

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
            @foreach ($user->businesses as $business)
                @include('components.business-card', ['business' => $business])
            @endforeach
        </div>

        <!-- Pagination -->
        {{-- <div class="d-flex justify-content-center">
            {{ $businesses->links() }}
        </div> --}}
    </div>
</x-layout>
