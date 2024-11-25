<?php
$metaDescription = "Top rated $topMessage";
?>
<x-layout pageTitle="Top rated businesses" :metaDescription="$metaDescription">
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
            <h2>{{ $metaDescription }}</h2>
        </div>

        @include('components.business-search', ['categories' => $categories])

        <div class="row justify-content-center">
            @forelse ($businesses as $business)
                @include('components.business-card', ['business' => $business])
            @empty
                <p class="text-center">No Businesses Found</p>
            @endforelse
        </div>
        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $businesses->withQueryString()->links() }}
        </div>
    </div>
</x-layout>
