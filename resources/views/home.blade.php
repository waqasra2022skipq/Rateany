<x-layout>
    <header class="text-center my-4">
        <h1>Find the top rated professionals and businesses</h1>
    </header>

    @include('components.carousel', ['reviews' => $reviews])
    <div class="container my-5">
        <h2 class="mb-4">Top Rated Businesses</h2>
    </div>

    @include('components.business-search', ['categories' => $categories])

    <div class="container my-5">
        <div class="row">
            @foreach ($topBusinesses as $business)
                @include('components.business-card', ['business' => $business])
            @endforeach
        </div>
    </div>




    <div class="container my-5">
        <h2 class="mb-4">Top Rated Professionals</h2>
    </div>
    @include('components.user-search', ['professions' => $professions])


    <div class="container my-5">
        <div class="row">
            @foreach ($topProfessionals as $Professional)
                @include('components.user-card', ['user' => $Professional])
            @endforeach
        </div>
    </div>

</x-layout>
