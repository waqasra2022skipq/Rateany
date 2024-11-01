<div class="col-md-3 mb-4">
    <div class="card h-100">
        <!-- User Profile Picture -->
        <a href="{{ route('user.show', $user->username) }}" class="user-link">
            <img src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : asset('default-user-logo.png') }}"
                alt="{{ $user->name }} Profile Picture" class="card-img-top img-fluid"
                style="height: 100px; object-fit: cover;">
        </a>

        <!-- User Info -->
        <div class="card-body">
            <h5 class="card-title">
                <a href="{{ route('user.show', $user->username) }}" class="user-link">
                    {{ $user->name }}
                </a>
            </h5>

            <p class="card-text">
                <strong>Ratings:</strong>
                <span>
                    {{ number_format($user->average_rating, 2) }} / 5
                    ({{ $user->reviews_count }} reviews)
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
            <p class="card-text">
                <strong>Location:</strong>
                <spanp>{{ $user->location }}</span>
            </p>

            <a href="{{ route('user.show', $user->username) }}" class="btn btn-primary btn-sm user-link">
                Write Review
            </a>
        </div>
    </div>
</div>
