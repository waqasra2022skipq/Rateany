<!-- Business Search Form -->
<div class="container my-5">
    <form action="{{ route('allUsers') }}" method="GET" class="row g-3">
        <!-- Category Select -->
        <div class="col-md-4">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="profession" name="profession">
                <option value="" selected>All Professions</option>
                @foreach ($professions as $profession)
                    <option value="{{ $profession->name }}">{{ $profession->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Business Name Search -->
        <div class="col-md-4">
            <label for="businessName" class="form-label">Username</label>
            <input type="text" class="form-control" id="userName" name="search" placeholder="Search by name">
        </div>

        <!-- Location Search -->
        <div class="col-md-4">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Search by location">
        </div>

        <!-- Search Button -->
        <div class="col-md-12 text-center mt-4">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
</div>
