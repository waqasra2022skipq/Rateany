<x-layout>
    <div class="container mt-5">
        <!-- User Profile Section -->
        <div class="text-center mb-5">
            <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
            <p class="text-muted">{{ $user->email }}</p>
            @if($user->profession)
                <p class="text-muted">Profession: {{ $user->profession->name }}</p>
            @endif
            <a href="{{ url('/profile/' . auth()->user()->id) . '/edit' }}" class="btn btn-success">Update Profile</a>
        </div>

        <!-- Businesses Section -->
        <div class="d-flex justify-content-between mb-4">
            <h3>Your Businesses</h3>
            <a href="{{ route('businesses.create') }}" class="btn btn-success">Add New Business</a>
        </div>

        <div class="row">
            @foreach ($businesses as $business)
                @include('components.business-card', ['business' => $business])
            @endforeach
        </div>
    </div>
</x-layout>
