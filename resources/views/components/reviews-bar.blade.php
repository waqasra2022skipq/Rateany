<div class="col-md-6">
    <div class="bg-light p-3 rounded">
        <h4><strong>{{ number_format($entity->average_rating, 1) }}</strong></h4>
        <p>{{ $entity->reviews_count }} Reviews</p>

        <!-- Rating Breakdown -->
        @php
            $totalReviews = $entity->reviews_count;
            $fiveStarPercentage = $totalReviews > 0 ? ($entity->{'5_star_count'} / $totalReviews) * 100 : 0;
            $fourStarPercentage = $totalReviews > 0 ? ($entity->{'4_star_count'} / $totalReviews) * 100 : 0;
            $threeStarPercentage = $totalReviews > 0 ? ($entity->{'3_star_count'} / $totalReviews) * 100 : 0;
            $twoStarPercentage = $totalReviews > 0 ? ($entity->{'2_star_count'} / $totalReviews) * 100 : 0;
            $oneStarPercentage = $totalReviews > 0 ? ($entity->{'1_star_count'} / $totalReviews) * 100 : 0;
        @endphp

        <div class="rating-breakdown">
            <div class="d-flex align-items-center mb-1">
                <span>5</span>
                <div class="progress w-75 ms-2">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $fiveStarPercentage }}%"
                        aria-valuenow="{{ $fiveStarPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span class="ms-2">{{ number_format($fiveStarPercentage, 0) }}%</span>
            </div>
            <div class="d-flex align-items-center mb-1">
                <span>4</span>
                <div class="progress w-75 ms-2">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $fourStarPercentage }}%"
                        aria-valuenow="{{ $fourStarPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span class="ms-2">{{ number_format($fourStarPercentage, 0) }}%</span>
            </div>
            <div class="d-flex align-items-center mb-1">
                <span>3</span>
                <div class="progress w-75 ms-2">
                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $threeStarPercentage }}%"
                        aria-valuenow="{{ $threeStarPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span class="ms-2">{{ number_format($threeStarPercentage, 0) }}%</span>
            </div>
            <div class="d-flex align-items-center mb-1">
                <span>2</span>
                <div class="progress w-75 ms-2">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $twoStarPercentage }}%"
                        aria-valuenow="{{ $twoStarPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span class="ms-2">{{ number_format($twoStarPercentage, 0) }}%</span>
            </div>
            <div class="d-flex align-items-center">
                <span>1</span>
                <div class="progress w-75 ms-2">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $oneStarPercentage }}%"
                        aria-valuenow="{{ $oneStarPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span class="ms-2">{{ number_format($oneStarPercentage, 0) }}%</span>
            </div>
        </div>
    </div>


</div>
