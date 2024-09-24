<x-layout>
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
            <h2>Top Businesses</h2>
        </div>

        <div class="row justify-content-center">
            @foreach ($businesses as $business)
                @include('components.business-card', ['business' => $business])
            @endforeach
        </div>
        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $businesses->links() }}
        </div>
    </div>
</x-layout>
