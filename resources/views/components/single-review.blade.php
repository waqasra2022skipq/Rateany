<figure
    class="flex flex-col items-center justify-center p-6 text-center bg-gray-50 border-b border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 business-card transform transition-transform hover:scale-105">
    <!-- Review Content -->
    <blockquote class="max-w-2xl mx-auto mb-4 text-gray-500 dark:text-gray-400">
        <!-- Stars -->
        <div class="mb-2">
            @for ($i = 1; $i <= $review->rating; $i++)
                @switch($review->rating)
                    @case(1)
                        @php $starColor = 'red'; @endphp
                    @break

                    @case(2)
                        @php $starColor = 'yellow'; @endphp
                    @break

                    @case(3)
                        @php $starColor = 'blue'; @endphp
                    @break

                    @case(4)
                        @php $starColor = 'blue'; @endphp
                    @break

                    @case(5)
                        @php $starColor = 'green'; @endphp
                    @break

                    @default
                @endswitch
                <i class="fa fa-star text-{{ $starColor }}-500"></i>
            @endfor
        </div>
        <!-- Review Text -->
        <p class="my-2 italic">"{{ Str::limit($review->comments, 125) }}"</p>
    </blockquote>

    <!-- Reviewer Info -->
    <figcaption class="flex items-center justify-center mt-4">
        <div class="text-left ms-3 rtl:text-right">
            <div class="text-lg font-semibold text-gray-800 dark:text-white">
                {{ $review->reviewer_name }}
            </div>
        </div>
    </figcaption>
</figure>
