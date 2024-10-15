<x-layout>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <header class="text-center mb-4">
                    <h2 class="text-2xl font-weight-bold mb-2">Register</h2>
                    <p>Create an account to post reviews and add businesses</p>
                </header>

                <form method="POST" action="/users" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="location" class="form-control @error('location') is-invalid @enderror"
                            id="location" name="location" value="{{ old('location') }}" />
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="profession_id" class="form-label">Profession</label>
                        <select id="profession_id" name="profession_id"
                            class="form-select @error('profession_id') is-invalid @enderror">
                            <option value="">Select Profession</option>
                            @foreach ($professions as $profession)
                                <option value="{{ $profession->id }}"
                                    {{ old('profession_id') == $profession->id ? 'selected' : '' }}>
                                    {{ $profession->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('profession')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Uncomment if you want to include password confirmation --}}
                    {{-- <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
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
                        <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                    </div>

                    <div class="text-center mt-3">
                        <p>
                            Already have an account?
                            <a href="/auth/login" class="btn btn-link">Login</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
