<div class="container my-5">
    <h2 class="text-center mb-4">Restaurants</h2>
    <div class="row">
        @foreach ($topRestaurants as $restaurant)
            @include('components.business-card', ['business' => $restaurant])
        @endforeach
    </div>
</div>
