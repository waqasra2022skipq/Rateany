<x-layout>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <header class="text-center mb-4">
                    <h2 class="text-2xl font-weight-bold mb-2">Update Profile</h2>
                    <p>Update your account details below.</p>
                </header>

                <!-- Display Profile Picture -->
                <div class="text-center mb-4">
                    @if (auth()->user()->profile_pic)
                        <img src="{{ asset('storage/' . auth()->user()->profile_pic) }}" alt="Profile Picture"
                            class="rounded-circle" width="150" height="150">
                    @else
                        <img src="{{ asset('default-user-logo.png') }}" alt="Default Profile Picture"
                            class="rounded-circle" width="150" height="150">
                    @endif
                </div>

                <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $user->name) }}" />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $user->email) }}" />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="location" class="form-control @error('location') is-invalid @enderror" id="location"
                            name="location" value="{{ old('location', $user->location) }}" />
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="profession" class="form-label">Profession</label>
                        <select id="profession" name="profession"
                            class="form-select @error('profession') is-invalid @enderror">
                            <option value="">Select Profession</option>
                            @foreach ($professions as $profession)
                                <option value="{{ $profession->id }}"
                                    {{ $profession->id == old('profession', $user->profession_id) ? 'selected' : '' }}>
                                    {{ $profession->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('profession')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password (Leave blank if you don't want to
                            change)</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Uncomment if you want to include password confirmation --}}
                    {{-- <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" />
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    <div class="mb-3">
                        <label for="profile_pic" class="form-label">Profile Picture</label>
                        <input type="file" name="profile_pic" id="profile_pic"
                            class="form-control @error('profile_pic') is-invalid @enderror" accept="image/*">

                        @error('profile_pic')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
