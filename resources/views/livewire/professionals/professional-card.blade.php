<div
    class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-lg transform transition-transform hover:scale-105 dark:bg-gray-800 dark:border-gray-700">
    <!-- Professional Profile Picture -->
    <a href="{{ route('user.show', $professional->username) }}">
        <img src="{{ $professional->profile_pic ? asset('storage/' . $professional->profile_pic) : asset('default-user-logo.png') }}"
            alt="{{ $professional->name }} Profile Picture" class="rounded-t-lg w-full h-20 object-cover">
    </a>

    <!-- Card Content -->
    <div class="p-5">
        <!-- Professional Name -->
        <a href="{{ route('user.show', $professional->username) }}">
            <h5 class="mb-2 text-lg font-bold text-gray-900 dark:text-white truncate">
                {{ Str::limit($professional->name, 25) }}
            </h5>
        </a>

        <!-- Profession -->
        <p class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-400 truncate">
            {{ $professional->profession->name }}
        </p>

        <!-- Review Stars -->
        @livewire('review-stars', ['entity' => $professional])

        <!-- Action Button -->
        <div class="mt-4">
            <a href="{{ route('user.show', $professional->username) }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-900">
                View
                <svg class="w-4 h-4 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
            </a>
        </div>
    </div>
</div>
