<x-layout>
    <form action="{{ route('businesses.store') }}" method="POST">
        @csrf
        <!-- Business Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Business Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name') }}" required maxlength="100">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- User ID (Hidden) -->
        <input type="hidden" name="userId" value="{{ Auth::id() }}">

        <!-- Category -->
        <div class="mb-3">
            <label for="categoryId" class="form-label">Category</label>
            <select class="form-select @error('categoryId') is-invalid @enderror" id="categoryId" name="categoryId"
                required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('categoryId') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('categoryId')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Location -->
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location"
                name="location" value="{{ old('location') }}">
            @error('location')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Create Business</button>
    </form>

</x-layout>
