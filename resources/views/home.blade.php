<x-layout>

    @include('components.carousel', ['reviews' => $reviews])
    <div class="container my-5">
        <h2 class="mb-4">Top Businesses</h2>
    </div>

    @include('components.business-search', ['categories' => $categories])

    <!-- Other Sections -->

    @include('components.top-restaurants-card', ['topRestaurants' => $topRestaurants])

    <div class="container my-5">
        <h2 class="text-center mb-4">Gyms <i class="fa-solid fa-dumbbell"></i></h2>
        <div class="row">
            @foreach ($topGyms as $gym)
                @include('components.business-card', ['business' => $gym])
            @endforeach
        </div>
    </div>

    <div class="container my-5">
        <h2 class="mb-4">Top Professionals</h2>
    </div>
    @include('components.user-search', ['professions' => $professions])


    <div class="container my-5">
        <h2 class="text-center mb-4">Mechanics <i class="fa-solid fa-gears"></i></h2>
        <div class="row">
            @foreach ($topMechanics as $user)
                @include('components.user-card', ['user' => $user])
            @endforeach
        </div>
    </div>

</x-layout>
