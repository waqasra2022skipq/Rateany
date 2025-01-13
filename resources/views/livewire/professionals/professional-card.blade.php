<div
    class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 professional-card transform transition-transform hover:scale-105">
    <a href="{{ route('user.show', $professional->username) }}">
        <img src="{{ $professional->profile_pic ? asset('storage/' . $professional->profile_pic) : asset('default-professional-logo.png') }}"
            alt="{{ $professional->name }} Logo" class="rounded-t-lg cover w-full h-40">
    </a>
    <div class="p-5 professional-card-content">
        <a href="{{ route('user.show', $professional->username) }}">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white professional-card-title">
                {{ Str::limit($professional->name, 25) }}
            </h5>
        </a>
        <a href="#">
            <h5 class="mb-2 tracking-tight text-gray-900 dark:text-white">
                {{ $professional->profession->name }}
            </h5>
        </a>
        @livewire('review-stars', ['entity' => $professional])
    </div>

    <div class="p-5 pb-2">
        <a href="{{ route('user.show', $professional->username) }}"
            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            View Details
            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 5h12m0 0L9 1m4 4L9 9" />
            </svg>
        </a>
    </div>
</div>
