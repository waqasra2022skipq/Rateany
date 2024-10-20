<x-layout>
    <div class="container mt-5">
        <header class="text-center mb-4">
            <h2 class="text-2xl font-bold">Login</h2>
            <p>Log into your account to create businesses</p>
        </header>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST" action="/auth/authenticate">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" />
                        @error('email')
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

                    <button type="submit" class="btn btn-primary w-100">Sign In</button>

                    <div class="mt-3 text-center">
                        <p>Don't have an account? <a href="/auth/register" class="text-primary">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
