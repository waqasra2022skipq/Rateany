<div>
    <section class="bg-gray-50 py-20">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold text-gray-800">Discover Top-Rated Professionals and Businesses!</h1>
            <p class="mt-4 text-gray-600">Explore reviews, ratings, and recommendations to make informed decisions.</p>
            <div class="mt-6">
                <input type="text" placeholder="Search businesses..." class="border p-4 rounded-lg w-1/2" />
                <button class="bg-blue-500 text-white px-6 py-4 rounded-lg ml-2">Search</button>
            </div>
        </div>
    </section>
    <section class="py-10 bg-white">
        <div class="container mx-auto">
            <h2 class="text-2xl font-bold mb-6">Top Rated Businesses</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($topBusinesses as $business)
                    <div class="border p-4 rounded-lg shadow">
                        <h3 class="text-lg font-semibold">{{ $business->name }}</h3>
                        <p class="text-gray-600">{{ $business->category->name }}</p>
                        <div class="mt-2">
                            <span class="text-yellow-500">★ {{ $business->average_rating }}</span>
                        </div>
                        <a href="/business/{{ $business->id }}" class="text-blue-500 mt-4 inline-block">View Details</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="py-10 bg-gray-50">
        <div class="container mx-auto">
            <h2 class="text-2xl font-bold mb-6">Browse by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <a href="/categories/restaurant" class="flex flex-col items-center p-4 bg-white shadow rounded-lg">
                    <img src="path-to-icon" alt="Restaurant" class="w-16 h-16">
                    <p class="mt-2 text-gray-800 font-semibold">Restaurants</p>
                </a>
                <!-- Add more categories -->
            </div>
        </div>
    </section>
    {{-- Latest Reviews --}}
    <section class="py-10 bg-gray-50">
        <div class="container mx-auto">
            <h2 class="text-2xl font-bold mb-6">Latest Reviews</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($reviews as $review)
                    <div class="border p-4 rounded-lg shadow">
                        <h3 class="text-lg font-semibold">{{ $review->business?->name }}</h3>
                        <p class="text-gray-600">{{ $review->reviewer?->name }}</p>
                        <div class="mt-2">
                            <span class="text-yellow-500">★ {{ $review->rating }}</span>
                        </div>
                        <p class="mt-4">{{ $review->comments }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="py-10 bg-gray-50">
        <div class="container mx-auto">
            <h2 class="text-2xl font-bold mb-6">Latest Reviews</h2>
            <div
                class="grid mb-8 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 md:mb-12 md:grid-cols-2 bg-white dark:bg-gray-800">
                @foreach ($reviews as $review)
                    <figure
                        class="flex flex-col items-center justify-center p-8 text-center bg-white border-b border-gray-200 rounded-t-lg md:rounded-t-none md:rounded-ss-lg md:border-e dark:bg-gray-800 dark:border-gray-700">
                        <blockquote class="max-w-2xl mx-auto mb-4 text-gray-500 lg:mb-8 dark:text-gray-400">
                            @for ($i = 1; $i <= $review->rating; $i++)
                                @switch($review->rating)
                                    @case(1)
                                        @php
                                            $starColor = 'red';
                                        @endphp
                                    @break

                                    @case(2)
                                        @php
                                            $starColor = 'yellow';
                                        @endphp
                                    @break

                                    @case(3)
                                        @php
                                            $starColor = 'blue';
                                        @endphp
                                    @break

                                    @case(4)
                                        @php
                                            $starColor = 'blue';
                                        @endphp
                                    @break

                                    @case(5)
                                        @php
                                            $starColor = 'green';
                                        @endphp
                                    @break

                                    @default
                                @endswitch
                                <i class="star fa fa-star text-{{ $starColor }}-500"></i>
                            @endfor
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $review->rating }}
                            </h3>
                            <p class="my-4">{{ $review->comments }}</p>
                        </blockquote>
                        <figcaption class="flex items-center justify-center ">
                            <div class="space-y-0.5 font-medium dark:text-white text-left rtl:text-right ms-3">
                                <div>{{ $review->reviewer?->name }}</div>
                            </div>
                        </figcaption>
                    </figure>
                @endforeach



            </div>
        </div>

    </section>

</div>
