<div class="col-md-3 mb-4">
    <div class="card h-100">
        <div class="card-body d-flex flex-row align-items-center">
            <!-- User Profile Picture -->
            <img src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : asset('default-user-logo.png') }}"
                alt="{{ $user->name }} Profile Picture" class="img-fluid rounded-circle"
                style="width: 100px; height: 100px; object-fit: cover; margin-right: 15px;">

            <!-- User Info -->
            <div>
                <h5 class="card-title">
                    <a href="{{ route('user.show', $user->username) }}" class="user-link">
                        {{ $user->name }}
                    </a>
                </h5>

                <p class="card-text">
                    <strong>Ratings:</strong>
                    <span>
                        {{ number_format($user->average_rating, 2) }} / 5
                        {{ $user->reviews_count }} reviews
                    </span>
                </p>

                <p class="card-text">
                    <strong>Profession:</strong>
                    @if ($user->profession)
                        <a href="{{ route('allUsers', ['profession' => $user->profession->slug]) }}"
                            class="user-link">{{ $user->profession->name }}</a>
                    @else
                        <span>No profession listed</span>
                    @endif
                </p>

                <a href="{{ route('user.show', $user->username) }}" class="btn btn-primary btn-sm user-link">
                    Write Review
                </a>
            </div>
        </div>
    </div>
</div>
