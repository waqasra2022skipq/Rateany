<x-layout>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <h2 class="mb-4">Edit Business</h2>

                <form action="{{ route('businesses.update', $business->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="userId" value="{{ old('userId', $business->userId) }}" required>
                    
                    <div class="form-group mb-3">
                        <label for="name">Business Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $business->name) }}" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="categoryId">Category</label>
                        <select name="categoryId" id="categoryId" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == old('categoryId', $business->categoryId) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('categoryId')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="location">Location</label>
                        <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $business->location) }}">
                        @error('location')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $business->description) }}</textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Business</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
