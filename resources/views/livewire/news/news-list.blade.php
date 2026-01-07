<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Noticias y Anuncios</h2>
        
        <!-- Filtros de categoría -->
        <div class="flex gap-2 mb-6 overflow-x-auto">
            <button wire:click="$set('category', '')" 
                class="px-4 py-2 rounded-md {{ $category === '' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-neutral-700 text-gray-700 dark:text-gray-300' }}">
                Todas
            </button>
            @foreach($categories as $key => $label)
                <button wire:click="$set('category', '{{ $key }}')" 
                    class="px-4 py-2 rounded-md whitespace-nowrap {{ $category === $key ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-neutral-700 text-gray-700 dark:text-gray-300' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Noticias destacadas -->
    @if($category === '' && $featured->isNotEmpty())
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Destacadas</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($featured as $item)
                    <a href="{{ route('news.show', $item->id) }}" 
                        class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        @if($item->image)
                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-blue-500 to-indigo-600"></div>
                        @endif
                        <div class="p-4">
                            <span class="inline-block px-2 py-1 text-xs rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 mb-2">
                                {{ ucfirst($item->category) }}
                            </span>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white line-clamp-2 mb-2">
                                {{ $item->title }}
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                {{ $item->excerpt }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Lista de noticias -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($news as $item)
            <article class="bg-white dark:bg-neutral-800 rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                @if($item->image)
                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-gray-400 to-gray-600"></div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="inline-block px-2 py-1 text-xs rounded-full bg-{{ $item->category === 'importante' ? 'red' : 'blue' }}-100 text-{{ $item->category === 'importante' ? 'red' : 'blue' }}-800">
                            {{ ucfirst($item->category) }}
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $item->published_at->diffForHumans() }}
                        </span>
                    </div>
                    
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white line-clamp-2 mb-2">
                        <a href="{{ route('news.show', $item->id) }}" class="hover:text-blue-600">
                            {{ $item->title }}
                        </a>
                    </h3>
                    
                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 mb-4">
                        {{ $item->excerpt }}
                    </p>
                    
                    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                        <span>{{ $item->views }} vistas</span>
                        <a href="{{ route('news.show', $item->id) }}" class="text-blue-600 hover:text-blue-700">
                            Leer más →
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 dark:text-gray-400">No hay noticias disponibles</p>
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    <div class="mt-8">
        {{ $news->links() }}
    </div>
</div>
