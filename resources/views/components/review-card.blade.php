<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">
            <a href="{{ route('user.show', $review->reviewer->id) }}" style="text-decoration: none;">
                {{ $review->reviewer->name }}
            </a>
        </h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ $review->created_at->format('F j, Y') }}</h6>
        <div class="mb-2">
            <strong>Rating:</strong> {{ $review->rating }}/5
        </div>
        <p class="card-text">{{ $review->comments }}</p>
    </div>
</div>
