<div>
    {{-- Hero section Start --}}
    @component('components.hero-section')
    @endcomponent

    {{-- Hero section END --}}

    {{-- Top Rated Businesses --}}
    <section class="p-10 bg-gray-50">
        <div class="container mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-4xl font-extrabold text-gray-800">Top Rated Businesses</h2>
                <p class="mt-4 text-lg text-gray-600">
                    Discover the most loved and highly rated businesses around you, trusted by thousands of customers.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Right: Top Rated Businesses -->
                <div class="md:col-span-2 order-1 md:order-none">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-10">
                        @foreach ($topBusinesses->take(6) as $business)
                            {{-- Limit to 6 businesses --}}
                            @livewire('business-card', ['business' => $business])
                        @endforeach
                    </div>
                    <!-- Browse All Businesses Button -->
                    <div class="mt-10 text-center">
                        <a href="{{ route('allBusinesses') }}"
                            class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
                            Browse All Businesses
                        </a>
                    </div>
                </div>

                <!-- Left: Top Rated Categories -->
                <div class="p-6 order-2 md:order-none flex justify-center">
                    <div class="w-full text-center">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Top Categories</h3>
                        <ul class="space-y-3">
                            @foreach ($categories as $category)
                                @if ($loop->index < 10)
                                    {{-- Display only top 10 categories --}}
                                    <li>
                                        <a href="{{ route('categoryPage', $category->slug) }}"
                                            class="text-blue-600 hover:underline font-medium">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <div class="mt-5">
                            <a href="{{ route('categories') }}"
                                class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
                                Explore All Categories
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    {{-- Top Rated Professionals --}}
    <section class="p-10 bg-blue-50">
        <div class="container mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-4xl font-extrabold text-gray-800">Top Rated Professional</h2>
                <p class="mt-4 text-lg text-gray-600">
                    Meet the top-rated professionals, trusted by clients for their exceptional skills and expertise.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Right: Top Rated Businesses -->
                <div class="md:col-span-2 order-1 md:order-none">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-10">
                        @foreach ($topProfessionals->take(6) as $professional)
                            @livewire('professionals.professional-card', ['professional' => $professional])
                        @endforeach
                    </div>
                    <!-- Browse All Businesses Button -->
                    <div class="mt-10 text-center">
                        <a href="{{ route('allUsers') }}"
                            class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
                            Browse All Professionals
                        </a>
                    </div>
                </div>

                <!-- Left: Top Rated Professionals -->
                <div class="p-6 order-2 md:order-none flex justify-center">
                    <div class="w-full text-center">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Top Professions</h3>
                        <ul class="space-y-3">
                            @foreach ($professions as $profession)
                                @if ($loop->index < 10)
                                    {{-- Display only top 10 categories --}}
                                    <li>
                                        <a href="{{ route('professionPage', $profession->slug) }}"
                                            class="text-blue-600 hover:underline font-medium">
                                            {{ $profession->name }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <div class="mt-5">
                            <a href="{{ route('professions') }}"
                                class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
                                Explore All Professions
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- Top Rated Professional End --}}


    {{-- Latest Reviews --}}
    {{-- @component('components.latest-reviews', ['reviews' => $reviews]) --}}
    @include('components.latest-reviews')


</div>
