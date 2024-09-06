{{-- @props(['listing']) --}}
<x-card>
    <div class="flex">
        {{-- <img class="hidden w-48 mr-6 md:block"
            src="{{ $listing->logo ? asset('storage/' . $listing->logo) : asset('images/no-image.png') }}"
            alt="" /> --}}
        <div>
            <h3 class="text-2xl">
                {{-- <a href="listings/{{ $listing->id }}">
                    {{ $listing->title }}
                </a> --}}
            </h3>
            <div class="text-xl font-bold mb-4">
                {{-- {{ $listing->company }} --}}

            </div>
            {{-- <x-listing-cats :catsCSV="$listing->categories" /> --}}

            <div class="text-lg mt-4">
                <i class="fa-solid fa-location-dot"></i>
                {{-- {{ $listing->location }} --}}
            </div>

            <div class="text-lg mt-4">
                {{-- <b>Last Date to Apply:</b> {{ \Carbon\Carbon::parse($listing->expires)->diffForHumans() }} --}}
            </div>
        </div>
    </div>
</x-card>
