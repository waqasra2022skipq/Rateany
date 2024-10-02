<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">
            @include('user.user-link')
        </h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ $review->created_at->format('F j, Y') }}</h6>
        <div class="mb-2">
            @switch($review->rating)
                @case(1)
                    @php
                        $starColor = 'danger';
                    @endphp
                @break

                @case(2)
                    @php
                        $starColor = 'warning';
                    @endphp
                @break

                @case(3)
                    @php
                        $starColor = 'info';
                    @endphp
                @break

                @case(4)
                    @php
                        $starColor = 'primary';
                    @endphp
                @break

                @case(5)
                    @php
                        $starColor = 'success';
                    @endphp
                @break

                @default
            @endswitch
            @for ($i = 1; $i <= $review->rating; $i++)
                <i class="star fa fa-star text-{{ $starColor }}"></i>
            @endfor
        </div>
        <p class="card-text">{{ $review->comments }}</p>
    </div>
</div>
