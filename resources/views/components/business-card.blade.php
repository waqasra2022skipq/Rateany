<div class="col-md-3 mb-4">
    <div class="card h-100">
        <!-- Business Logo -->
        <img src="{{ $business->business_logo ? asset('storage/' . $business->business_logo) : asset('default-business-logo.png') }}"
            alt="{{ $business->name }} Logo" class="card-img-top img-fluid" style="height: 100px; object-fit: cover;">

        <div class="card-body">
            <h5 class="card-title">
                <a href="{{ route('businesses.show', $business->id) }}" class="business-link">
                    {{ $business->name }}
                </a>
            </h5>

            <p class="card-text">
                <strong>Ratings:</strong>
                <span>
                    {{ number_format($business->average_rating, 1) }} / 5
                </span>
            </p>

            <p class="card-text">
                <strong>Category:</strong>
                <a href="{{ route('allBusinesses', ['categoryId' => $business->category->id]) }}"
                    class="business-link">{{ $business->category->name }}</a>
            </p>

            <p class="card-text">
                <strong>Owner:</strong>
                <a href="{{ route('user.show', $business->owner->id) }}"
                    class="business-link">{{ $business->owner->name }}</a>
            </p>

            <p class="card-text">
                <strong>Location:</strong>
                <spanp>{{ $business->location }}</span>
            </p>

            @if (auth()->check() && auth()->user()->id == $business->userId)
                <a href="{{ route('businesses.edit', $business->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('businesses.destroy', $business->id) }}" method="POST"
                    style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            @else
                <a href="{{ route('businesses.write-review', $business->id) }}" class="btn btn-primary btn-sm">Write
                    Review</a>
            @endif
        </div>
    </div>
</div>
