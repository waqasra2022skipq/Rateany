<x-layout pageTitle="Register" metaDescription="Sign Up now to create businesses and build your professional profile">
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
                        <label for="bio">Bio</label>
                        <textarea name="bio" id="bio" class="form-control" rows="4">{{ old('bio') }}</textarea>
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
                        <span>Could find the your suited profession ? <a class="user-link"
                                href={{ route('contact.show') }}>Write to
                                us</a></span>
                        @error('profession')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contact Phone -->
                    <div class="mb-3">
                        <label for="contact_phone" class="form-label">Contact Phone</label>
                        <input type="tel" class="form-control @error('contact_phone') is-invalid @enderror" 
                            id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}">
                        @error('contact_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contact Website -->
                    <div class="mb-3">
                        <label for="contact_website" class="form-label">Website</label>
                        <input type="url" class="form-control @error('contact_website') is-invalid @enderror" 
                            id="contact_website" name="contact_website" value="{{ old('contact_website') }}"
                            placeholder="https://example.com">
                        @error('contact_website')
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
                        <!-- Google Recaptcha Widget-->
                        <div class="g-recaptcha mt-4" data-sitekey={{ config('services.recaptcha.key') }}></div>
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
