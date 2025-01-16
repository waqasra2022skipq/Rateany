<div>
    {{-- Hero section Start --}}
    @component('components.hero-section')
    @endcomponent

    {{-- Hero section END --}}

    {{-- Top Rated Businesses --}}
    <section class="py-10 bg-gray-50">
        <div class="container mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-4xl font-extrabold text-gray-800">Top Rated Businesses</h2>
                <p class="mt-4 text-lg text-gray-600">
                    Discover the most loved and highly rated businesses around you, trusted by thousands of customers.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach ($topBusinesses as $business)
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

    {{-- Top Rated Professional --}}
    <section class="py-10 bg-gray-50 mb-10">
        <div class="container mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-4xl font-extrabold text-gray-800">Top Rated Professionals</h2>
                <p class="mt-4 text-lg text-gray-600">
                    Meet the top-rated professionals, trusted by clients for their exceptional skills and expertise.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach ($topProfessionals as $professional)
                    @livewire('professionals.professional-card', ['professional' => $professional])
                @endforeach
            </div>
            <div class="mt-10 text-center">
                <a href="{{ route('allUsers') }}"
                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
                    Browse All Professionals
                </a>
            </div>
        </div>
    </section>
    {{-- Top Rated Professional End --}}


    {{-- Latest Reviews --}}
    {{-- @component('components.latest-reviews', ['reviews' => $reviews]) --}}
    @include('components.latest-reviews')


</div>
