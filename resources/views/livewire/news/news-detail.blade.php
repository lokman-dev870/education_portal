<div>
    <div class="mb-6">
        <a href="{{ route('search') }}" class="text-blue-600 hover:text-blue-700 mb-4 inline-block">
            ← Volver a búsqueda
        </a>
    </div>

    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-8 mb-6">
        <div class="flex items-center justify-between mb-4">
            <span class="inline-block px-3 py-1 text-sm rounded-full bg-{{ $news->category === 'importante' ? 'red' : 'blue' }}-100 text-{{ $news->category === 'importante' ? 'red' : 'blue' }}-800">
                {{ ucfirst($news->category) }}
            </span>
            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ $news->published_at->format('d/m/Y') }} • {{ $news->views }} vistas
            </span>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $news->title }}</h1>

        @if($news->image)
            <img src="{{ Storage::url($news->image) }}" alt="{{ $news->title }}" class="w-full h-96 object-cover rounded-lg mb-6">
        @endif

        <div class="prose dark:prose-invert max-w-none">
            {!! nl2br(e($news->content)) !!}
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-neutral-700">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr($news->user->name, 0, 1)) }}
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $news->user->name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Publicado por</p>
                </div>
            </div>
        </div>
    </div>

    @if($relatedNews->isNotEmpty())
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Noticias Relacionadas</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($relatedNews as $related)
                    <a href="{{ route('news.show', $related->id) }}" 
                        class="block p-4 rounded-lg border border-gray-200 dark:border-neutral-700 hover:shadow-md transition-shadow">
                        <h4 class="font-semibold text-gray-900 dark:text-white line-clamp-2 mb-2">
                            {{ $related->title }}
                        </h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                            {{ $related->excerpt }}
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
