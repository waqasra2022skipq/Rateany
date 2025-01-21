<section>
    <!-- Header -->
    <div class="bg-blue-50 py-8">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold text-gray-800">{{ $pageTitle }}</h1>
            <p class="mt-4 text-lg text-gray-600">
                Explore a wide range of categories to find the best-rated businesses.
            </p>
            <div class="mt-6">
                <input type="text" wire:model="search" wire:input='$refresh' placeholder="Search categories..."
                    class="w-full max-w-md px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="container mx-auto py-10">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @foreach ($categories as $category)
                <a href="{{ route('categoryPage', $category->slug) }}"
                    class="flex flex-col items-center p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-4">
                        <!-- Replace with category icon or dynamic content -->
                        <i class="fas fa-tag"></i>
                    </div>
                    <h3 class="text-sm font-medium text-gray-800 text-center">
                        {{ $category->name }}
                    </h3>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4 mb-2">
        {{ $categories->links() }}
    </div>
</section>
