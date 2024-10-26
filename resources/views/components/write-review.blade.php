    <div class="row">
        <form action="{{ route('reviews.store') }}" method="POST">
            @csrf
            @isset($business_id)
                <input type="hidden" name="business_id" value="{{ $business_id }}">
            @endisset

            @isset($user_id)
                <input type="hidden" name="user_id" value="{{ $user_id }}">
            @endisset
            <div class="mb-3">
                <label for="rating">Rating</label>
                <div class="star-rating d-flex">
                    <i class="star fa fa-star rev-star" data-value="1"></i>
                    <i class="star fa fa-star rev-star" data-value="2"></i>
                    <i class="star fa fa-star rev-star" data-value="3"></i>
                    <i class="star fa fa-star rev-star" data-value="4"></i>
                    <i class="star fa fa-star rev-star" data-value="5"></i>
                </div>
                <input type="hidden" name="rating" id="rating" value="1"> <!-- Default value -->
            </div>

            <div class="mb-3">
                <label for="comment">Comment</label>
                <textarea name="comment" class="form-control" rows="7" cols="30" placeholder="Share Your Experience"></textarea>
            </div>
            <div class="mb-3">
                @auth
                    <input type="hidden" name="reviewer_id" value="{{ auth()->user()->id }}">
                @else
                    <div class="row">
                        <!-- Name Field -->
                        <div class="form-group col-md-6">
                            <label for="reviewer_name">Your Name</label>
                            <input type="text" name="reviewer_name" id="reviewer_name" class="form-control" required>
                            @error('reviewer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Email Field -->
                        <div class="form-group col-md-6">
                            <label for="reviewer_email">Your Email</label>
                            <input type="email" name="reviewer_email" id="reviewer_email" class="form-control" required>
                            @error('reviewer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <!-- Google Recaptcha Widget-->
                            <div class="g-recaptcha mt-4" data-sitekey={{ config('services.recaptcha.key') }}></div>
                        </div>
                    </div>
                @endauth
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    </div>

    <style>
        .rev-star {
            font-size: 2rem;
            color: #ccc;
            cursor: pointer;
            margin-right: 5px;
        }

        .rev-star.selected,
        .rev-star:hover {
            color: gold;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.rev-star');
            let selectedRating = document.getElementById('rating').value;

            stars.forEach((star) => {
                // Highlight selected stars on page load
                if (star.dataset.value <= selectedRating) {
                    star.classList.add('selected');
                }

                star.addEventListener('click', function() {
                    const ratingValue = this.getAttribute('data-value');
                    selectedRating = ratingValue

                    document.getElementById('rating').value = ratingValue;

                    // Highlight the stars up to the clicked one
                    stars.forEach((s) => {
                        s.classList.remove('selected');

                        if (s.getAttribute('data-value') <= ratingValue) {
                            s.classList.add('selected');
                        }
                    });
                });

                star.addEventListener('mouseover', function() {
                    // Highlight stars on hover
                    stars.forEach((s) => {
                        s.classList.remove('selected');
                        if (s.getAttribute('data-value') <= this.getAttribute(
                                'data-value')) {
                            s.classList.add('selected');
                        }
                    });
                });

                star.addEventListener('mouseout', function() {
                    // Re-highlight stars based on current rating when mouse leaves
                    stars.forEach((s) => {
                        s.classList.remove('selected');
                        if (s.getAttribute('data-value') <= selectedRating) {
                            s.classList.add('selected');
                        }
                    });
                });
            });
        });
    </script>
