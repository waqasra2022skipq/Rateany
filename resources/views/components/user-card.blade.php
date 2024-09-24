<div class="col-md-4 mb-4">
    <div class="card h-100">
        <div class="card-body">
            <h5 class="card-title">
                <a href="{{ route('user.show', $user->id) }}" class="user-link">
                    {{ $user->name }}
                </a>
            </h5>

            <p class="card-text">
                <strong>Ratings:</strong>
                <span>
                    {{ number_format($user->average_rating, 1) }} / 5
                </span>
            </p>

            <p class="card-text">
                <strong>Profession:</strong>
                <a href="{{ route('allUsers', ['profession_id' => $user->profession_id]) }}"
                    class="user-link">{{ $user->profession->name }}</a>
            </p>
            @if (auth()->check() && auth()->user()->id == $user->userId)
                <a href="{{ route('useres.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('useres.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            @else
                <a href="{{ route('user.write-review', $user->id) }}" class="btn btn-primary btn-sm">Write
                    Review</a>
            @endif
        </div>
    </div>
</div>
