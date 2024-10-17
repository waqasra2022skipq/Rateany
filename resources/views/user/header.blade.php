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
    </div>
</div>


@include('components.reviews-bar', ['entity' => $user])
<!-- Edit/Delete Buttons or Write Review -->
<div class="col-md-2 text-center">
    @if (auth()->check() && auth()->user()->id == $user->id)
        <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary btn mt-3">Update Profile</a>
    @endif
</div>
