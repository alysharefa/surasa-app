@props(['kuliner'])

<div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition group">
    <a href="{{ route('kuliners.show', $kuliner->slug) }}">
        <!-- Image -->
        <div class="relative h-48 overflow-hidden">
            @if($kuliner->image)
                <img src="{{ asset('storage/' . $kuliner->image) }}" alt="{{ $kuliner->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
            @else
                <div class="w-full h-full bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
                    <svg class="w-16 h-16 text-orange-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            @endif

            <!-- Rating Badge -->
            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full flex items-center gap-1">
                <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="text-sm font-semibold text-gray-700">{{ number_format($kuliner->average_rating, 1) }}</span>
            </div>

            @if($kuliner->is_featured)
                <div class="absolute top-3 left-3 bg-orange-500 text-white text-xs px-2 py-1 rounded-full font-medium">
                    Featured
                </div>
            @endif
        </div>

        <!-- Content -->
        <div class="p-4">
            <div class="text-xs text-orange-500 font-medium mb-1">
                {{ $kuliner->category->name ?? 'Uncategorized' }}
            </div>
            <h3 class="font-bold text-gray-800 mb-2 group-hover:text-orange-500 transition">
                {{ $kuliner->name }}
            </h3>
            <div class="flex items-center text-gray-500 text-sm mb-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $kuliner->location }}
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">{{ $kuliner->price_range }}</span>
                <span class="text-xs text-gray-400">{{ $kuliner->total_reviews }} ulasan</span>
            </div>
        </div>
    </a>
</div>
