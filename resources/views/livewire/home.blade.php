<div>
    {{-- Hero section Start --}}

    <section class="bg-gray-50 py-20 hero-section">
        <div class="container mx-auto text-center lg:text-left text-white">
            <h1 class="text-4xl lg:text-5xl font-bold ">
                Discover Top-Rated Professionals and Businesses!
            </h1>
            <p class="mt-4 text-lg lg:text-xl ">
                Explore reviews, ratings, and recommendations to make informed decisions.
            </p>
            <div class="flex flex-col lg:flex-row  items-start gap-10 mt-10 text-black">
                <!-- Business Search Form -->
                <div class="bg-white p-6 rounded-lg shadow-lg w-full lg:w-1/3">
                    <h2 class="text-xl font-semibold text-gray-800">Search Businesses</h2>
                    <form class="mt-4 space-y-4" action="{{ route('allBusinesses') }}">
                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Select a
                                Category:</label>
                            <input list="categories" class="w-full rounded px-4 py-2 border border-gray-300"
                                id="category" name="category" value="{{ request('category') }}"
                                placeholder="Search Category..." autocomplete="off">
                            <datalist id="categories" class="custom-select">
                                <option value="All Categories"></option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <!-- Business Name -->
                        <div>
                            <label for="business-name" class="block text-sm font-medium text-gray-700">Business
                                Name</label>
                            <input type="text" id="business-name" name="search"
                                class="block w-full border-gray-300 rounded-lg shadow-sm"
                                placeholder="Enter business name">
                        </div>
                        <!-- Location -->
                        <div>
                            <label for="business-location"
                                class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" id="business-location" name="location"
                                class="block w-full border-gray-300 rounded-lg shadow-sm" placeholder="Enter location">
                        </div>
                        <button
                            class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Search
                        </button>
                    </form>
                </div>

                <!-- Professional Search Form -->
                <div class="bg-white p-6 rounded-lg shadow-lg w-full lg:w-1/3">
                    <h2 class="text-xl font-semibold text-gray-800">Search Professionals</h2>
                    <form class="mt-4 space-y-4" action="{{ route('allUsers') }}">
                        <!-- Profession -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Select a
                                Profession:</label>
                            <input list="professions" class="w-full rounded px-4 py-2 border border-gray-300"
                                id="category" name="profession" value="{{ request('profession') }}"
                                placeholder="Search profession..." autocomplete="off">
                            <datalist id="professions" class="custom-select">
                                <option value="All Categories"></option>
                                @foreach ($professions as $professions)
                                    <option value="{{ $professions->slug }}">{{ $professions->name }}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <!-- Professional Name -->
                        <div>
                            <label for="professional-name" class="block text-sm font-medium text-gray-700">Professional
                                Name</label>
                            <input type="text" id="professional-name" name="search"
                                class="block w-full border-gray-300 rounded-lg shadow-sm"
                                placeholder="Enter professional name">
                        </div>
                        <!-- Location -->
                        <div>
                            <label for="professional-location"
                                class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" id="professional-location" name="location"
                                class="block w-full border-gray-300 rounded-lg shadow-sm" placeholder="Enter location">
                        </div>
                        <button
                            class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Search
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>


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
