{{-- 
    Category Card Component - DistroZone Design System
    
    Props:
    - $category: Category model with name, slug, image
--}}

@props(['category'])

<a href="{{ route('guest.catalog', ['category' => $category->slug]) }}"
    class="group block bg-bg-secondary rounded-lg overflow-hidden hover:border-2 hover:border-accent transition-base">

    <!-- Category Image (if available) -->
    <div class="aspect-square overflow-hidden bg-white">
        @if (isset($category->image))
            <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-base">
        @else
            <!-- Icon Placeholder -->
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
            </div>
        @endif
    </div>

    <!-- Category Name -->
    <div class="p-4 text-center">
        <h3 class="text-gray-800 font-semibold text-lg group-hover:text-accent transition-fast">
            {{ $category->name }}
        </h3>
        @if (isset($category->description))
            <p class="text-text-secondary text-sm mt-1">
                {{ $category->description }}
            </p>
        @endif
    </div>
</a>
