<div class="col-md-4 mb-4">
    <div class="card h-100">
        <div class="card-body">
            <h5 class="card-title">
                <a href="{{ route('businesses.show', $business->id) }}" style="text-decoration: none;">
                    {{ $business->name }}
                </a>
            </h5>
            <p class="card-text">
                <strong>Category:</strong>
                <a href="{{ route('businesses.categories', $business->category->id) }}"
                    style="text-decoration: none;">{{ $business->category->name }}</a>
            </p>
            <p class="card-text">
                <strong>Owner:</strong>
                <a href="{{ route('user.show', $business->owner->id) }}"
                    style="text-decoration: none;">{{ $business->owner->name }}</a>
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
