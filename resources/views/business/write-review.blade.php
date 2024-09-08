<x-layout>
    <form action="{{ route('reviews.store') }}" method="POST">
    @csrf
    <input type="hidden" name="business_id" value="{{ $business_id }}">
    <div class="mb-3">
        <label for="rating">Rating</label>
        <select name="rating" class="form-control">
            <option value="5">5 - Excellent</option>
            <option value="4">4 - Good</option>
            <option value="3">3 - Average</option>
            <option value="2">2 - Poor</option>
            <option value="1">1 - Terrible</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="comment">Comment</label>
        <textarea name="comment" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit Review</button>
</form>

</x-layout>