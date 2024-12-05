<!-- Business Search Form -->
<div class="container my-5">
    <form action="{{ route('allBusinesses') }}" method="GET" class="row g-3">
        <!-- Category Select -->
        <div class="col-md-4">
            <label for="category" class="form-label">Select a Category:</label>
            <input list="categories" class="form-control" id="category" name="category" value="{{ request('category') }}"
                placeholder="Search Category...">
            <datalist id="categories" class="custom-select">
                <option value="All Categories"></option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}">{{ $category->name }}</option>
                @endforeach
            </datalist>

        </div>

        <!-- Business Name Search -->
        <div class="col-md-4">
            <label for="businessName" class="form-label">Business Name</label>
            <input type="text" class="form-control" id="businessName" value="{{ request('search') }}" name="search"
                placeholder="Search by name">
        </div>

        <!-- Location Search -->
        <div class="col-md-4">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ request('location') }}"
                placeholder="Search by location">
        </div>

        <!-- Search Button -->
        <div class="col-md-12 text-center mt-4">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
</div>
