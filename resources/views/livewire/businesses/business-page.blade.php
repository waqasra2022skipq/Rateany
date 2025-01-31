<div>
    {{-- Business Page Header Start --}}
    @component('components.businesses.business-page-header', [
        'business' => $business,
        'ratingBreakdown' => $ratingBreakdown,
    ])
    @endcomponent
    {{-- Business Page Header End --}}
</div>
