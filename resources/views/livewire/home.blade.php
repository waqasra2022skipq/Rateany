<div>
    {{-- Hero section Start --}}
    @component('components.hero-section')
    @endcomponent

    {{-- Hero section END --}}

    {{-- Top Rated Businesses --}}

    @livewire('top-rated-business')


    {{-- Latest Reviews --}}
    {{-- @component('components.latest-reviews', ['reviews' => $reviews]) --}}
    <div id="latest-reviews">
        @include('components.latest-reviews')
    </div>


</div>
