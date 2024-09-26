<x-layout>
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
            <h2>Top Professionals</h2>
        </div>

        @include('components.user-search', ['professions' => $professions])

        <div class="row justify-content-center">
            @foreach ($users as $user)
                @include('components.user-card', ['user' => $user])
            @endforeach
        </div>
        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
</x-layout>
