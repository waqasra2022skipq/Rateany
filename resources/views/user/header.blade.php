<div class="col-md-4 d-flex align-items-center">
    <div>
        @if ($user->profile_pic)
            <img src="{{ asset('storage/' . $user->profile_pic) }}" alt="User Logo" class="rounded" width="150"
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
                </strong></p>
        @endif
    </div>
</div>

@include('components.reviews-bar', ['entity' => $user])
<!-- Edit/Delete Buttons or Write Review -->
<div class="col-md-2">
    @if (auth()->check() && auth()->user()->id == $user->id)
        <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary btn mt-3">Update Profile</a>
    @endif
</div>
