<div class="mt-2">
    @for ($i = 1; $i <= 5; $i++)
        @if ($i <= $entity->average_rating)
            <i class="fas fa-star text-yellow-500"></i>
        @elseif($i - 0.5 <= $entity->average_rating)
            <i class="fas fa-star-half-alt text-yellow-500"></i>
        @else
            <i class="far fa-star text-yellow-500"></i>
        @endif
    @endfor
    <strong>{{ number_format($entity->average_rating, 1) }}
        ({{ $entity->reviews_count }})</strong>
</div>
