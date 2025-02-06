<div class="mx-auto sm:px-6 lg:px-8 hero-section text-white">
    <div
        class="relative px-6 py-10 overflow-hidden text-center  isolate sm:px-16 sm:shadow-sm dark:bg-transparent bg-[#70696907]">

        <div class="flex flex-col justify-between mt-10">
            <p class="max-w-2xl mx-auto text-3xl font-bold tracking-tight  dark:text-gray-200 sm:text-4xl">
                Discover Top-Rated Businesses, Professionals and many more!
            </p>

            <p class="max-w-xl mx-auto mt-6 text-lg leading-8 dark:text-gray-300">
                Explore reviews, ratings, and recommendations to make informed decisions.
            </p>

            <div class="text-black">
                <form action="{{ route('allBusinesses') }}">
                    <div
                        class="relative flex flex-col items-center justify-center max-w-2xl gap-2 px-2 py-2 mx-auto mt-8 bg-white border shadow-2xl dark:bg-gray-50 min-w-sm md:flex-row rounded-2xl focus-within:border-gray-300">

                        <input id="search-bar" placeholder="Search resturarants, doctors, books or anything"
                            name="search"
                            class="flex-1 w-full px-6 py-2 bg-white rounded-md outline-none dark:bg-gray-50"
                            required="">
                        <button type="submit"
                            class="relative w-full px-6 py-3 overflow-hidden text-white transition-all duration-100 bg-button hover:bg-button-hover md:w-auto fill-white active:scale-95 will-change-transform rounded-xl">
                            <span class="flex items-center transition-all opacity-1">
                                <span class="mx-auto text-sm font-semibold truncate whitespace-nowrap">
                                    Search Now
                                </span>
                            </span>
                        </button>
                    </div>
                </form>

                {{-- <form action="{{ route('allUsers') }}">
                    <div
                        class="relative flex flex-col items-center justify-center max-w-2xl gap-2 px-2 py-2 mx-auto mt-8 bg-white border shadow-2xl dark:bg-gray-50 min-w-sm md:flex-row rounded-2xl focus-within:border-gray-300">

                        <input id="search-bar" placeholder="Professional Name" name="search"
                            class="flex-1 w-full px-6 py-2 bg-white rounded-md outline-none dark:bg-gray-50"
                            required="">
                        <button type="submit"
                            class="relative w-full px-6 py-3 overflow-hidden text-white transition-all duration-100 bg-button hover:bg-button-hover md:w-auto fill-white active:scale-95 will-change-transform rounded-xl">
                            <span class="flex items-center transition-all opacity-1">
                                <span class="mx-auto text-sm font-semibold truncate whitespace-nowrap">
                                    Search Professionals
                                </span>
                            </span>
                        </button>
                    </div>
                </form> --}}
            </div>
            <div class="mt-6 flex justify-center gap-2">
                <a href="#top-rated-section"
                    class="text-white bg-button hover:bg-button-hover focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Top
                    Rated <i class="fas fa-arrow-down"></i> </a>

                <a href="#latest-reviews"
                    class="text-white bg-button hover:bg-button-hover focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Latest
                    Reviews <i class="fas fa-arrow-down"></i></a>
                {{-- <a href="{{ route('allBusinesses') }}"
                    class="text-white bg-button hover:bg-button-hover focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Rate
                    a Business</a> --}}
                {{-- <a href="{{ route('allUsers') }}"
                    class="text-white bg-button hover:bg-button-hover focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Rate
                    a Professional</a> --}}
            </div>
        </div>

    </div>
</div>
