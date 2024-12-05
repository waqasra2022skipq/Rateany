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
                        <label for="bio">Bio</label>
                        <textarea name="bio" id="bio" class="form-control" rows="4">{{ old('bio', auth()->user()->bio) }}</textarea>
                    </div>


                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="location" class="form-control @error('location') is-invalid @enderror"
                            id="location" name="location" value="{{ old('location', $user->location) }}" />
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="profession_slug" class="form-label">Profession</label>
                        <input list="professions" class="form-control" id="profession_slug" name="profession_slug"
                            value="{{ $user->profession->name }}" placeholder="Search Profession...">
                        <datalist id="professions" class="custom-select">
                            <option value="All Professions"></option>
                            @foreach ($professions as $profession)
                                <option value="{{ $profession->slug }}">{{ $profession->name }}</option>
                            @endforeach
                        </datalist>

                        <span>Could find the your suited profession ? <a class="user-link"
                                href={{ route('contact.show') }}>Write to
                                us</a></span>
                        @error('profession_slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="contact_phone">Contact Phone</label>
                        <input type="tel" name="contact_phone" id="contact_phone" class="form-control"
                            value="{{ old('contact_phone', $user->contact_phone) }}">
                        @error('contact_phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="contact_website">Website</label>
                        <input type="url" name="contact_website" id="contact_website" class="form-control"
                            value="{{ old('contact_website', $user->contact_website) }}"
                            placeholder="https://example.com">
                        @error('contact_website')
                            <div class="text-danger">{{ $message }}</div>
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
