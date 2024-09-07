<x-layout>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <header class="text-center mb-4">
                    <h2 class="text-2xl font-weight-bold mb-2">Update Profile</h2>
                    <p>Update your account details below.</p>
                </header>

                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name', $user->name) }}" />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                            value="{{ old('email', $user->email) }}" />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="profession" class="form-label">Profession</label>
                        <select id="profession" name="profession" class="form-select @error('profession') is-invalid @enderror">
                            <option value="">Select Profession</option>
                            @foreach ($professions as $profession)
                                <option value="{{ $profession->id }}" {{ $profession->id == old('profession', $user->profession_id) ? 'selected' : '' }}>
                                    {{ $profession->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('profession')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password (Leave blank if you don't want to change)</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" />
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
                        <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
