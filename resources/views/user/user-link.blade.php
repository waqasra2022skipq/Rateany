@if (auth()->check() && auth()->user()->id == $review->reviewer->id)
    <a href="{{ route('profile.show', $review->reviewer->id) }}" class="user-link">
        {{ $review->reviewer->name }}
    </a>
@else
    <a href="{{ route('user.show', $review->reviewer->username) }}" class="user-link">
        {{ $review->reviewer->name }}
    </a>
@endif
