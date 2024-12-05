<div class="col-md-4 d-flex flex-column flex-md-row align-items-center">
    <div class="text-center text-md-start mb-3 mb-md-0">
        @if ($user->profile_pic)
            <img src="{{ asset('storage/' . $user->profile_pic) }}" alt="User Logo" class="rounded"
                style="width: 150px; height: 150px;">
        @else
            <img src="{{ asset('default-user-logo.png') }}" alt="Default User Logo" class="rounded"
                style="width: 150px; height: 150px;">
        @endif
    </div>
    <div class="ms-md-3 text-center text-md-start">
        <h2>{{ $user->name }}</h2>
        <p class="card-text">
            <strong>Profession:</strong>
            @if ($user->profession)
                <a href="{{ route('allUsers', ['profession' => $user->profession->slug]) }}"
                    class="user-link">{{ $user->profession->name }}</a>
            @else
                <span>No profession listed</span>
            @endif
        </p>
        <p><strong>Location:</strong> {{ $user->location }}</p>
    </div>
</div>


@include('components.reviews-bar', ['entity' => $user])

@include('components.sharing', ['entity' => $user, 'type' => 'user'])
<!-- Edit/Delete Buttons or Write Review -->

<div class="profile-bio">
    <h4>Bio</h4>
    <p>{{ $user->bio ?? 'No bio available.' }}</p>
</div>
