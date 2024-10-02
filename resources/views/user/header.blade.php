<div class="col-md-8 d-flex align-items-center">
    <div>
        @if ($user->profile_pic)
            <img src="{{ asset('storage/' . $user->profile_pic) }}" alt="user Logo" class="rounded" width="150"
                height="150">
        @else
            <img src="{{ asset('default-user-logo.png') }}" alt="Default User Logo" class="rounded" width="150"
                height="150">
        @endif
    </div>
    <div class="ms-3">
        <h2>{{ $user->name }}</h2>
        <p class="text-muted">{{ $user->email }}</p>
        @if ($user->profession)
            <h2>Profession</h2>
            <p><strong>
                    <a href="{{ route('allUsers', ['profession' => $user->profession->slug]) }}"
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
    <!-- Edit/Delete Buttons or Write Review -->
    @if (auth()->check() && auth()->user()->id == $user->id)
        <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary btn">Update Profile</a>
    @endif
</div>
