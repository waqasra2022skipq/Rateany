<x-layout>
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
            <h2>Manage Businesses</h2>
            <a href="{{ route('businesses.create') }}" class="btn btn-success">Create New Business</a>
        </div>

        <div class="row justify-content-center">
            @foreach ($businesses as $business)
                @include('components.business-card', ['business' => $business])
            @endforeach
        </div>
    </div>
</x-layout>
