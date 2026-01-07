<div>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Búsqueda Global</h2>
        
        <div class="flex flex-col md:flex-row gap-4">
            <input type="text" wire:model.live.debounce.300ms="query" placeholder="Buscar en el portal..." 
                class="flex-1 rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg py-3 px-4">
            
            <select wire:model.live="type" 
                class="rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="all">Todo</option>
                <option value="resources">Recursos</option>
                <option value="forums">Foros</option>
                <option value="news">Noticias</option>
                <option value="events">Eventos</option>
            </select>
        </div>

        @if($query && $totalResults > 0)
            <p class="mt-4 text-gray-600 dark:text-gray-400">
                Se encontraron <span class="font-semibold">{{ $totalResults }}</span> resultados para "<span class="font-semibold">{{ $query }}</span>"
            </p>
        @endif
    </div>

    @if($query)
        <!-- Recursos -->
        @if($results['resources']->isNotEmpty())
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Recursos ({{ $results['resources']->count() }})
                </h3>
                <div class="space-y-3">
                    @foreach($results['resources'] as $resource)
                        <a href="{{ route('resources.show', $resource->id) }}" 
                            class="block bg-white dark:bg-neutral-800 rounded-lg shadow p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                            {{ ucfirst($resource->type) }}
                                        </span>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ $resource->title }}</h4>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $resource->description }}</p>
                                    <div class="mt-2 flex gap-3 text-xs text-gray-500 dark:text-gray-400">
                                        <span>{{ $resource->career }}</span>
                                        <span>{{ $resource->subject }}</span>
                                        <span>{{ $resource->downloads }} descargas</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Temas de Foro -->
        @if($results['forum_topics']->isNotEmpty())
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Temas de Foro ({{ $results['forum_topics']->count() }})
                </h3>
                <div class="space-y-3">
                    @foreach($results['forum_topics'] as $topic)
                        <a href="{{ route('forums.topic', $topic->id) }}" 
                            class="block bg-white dark:bg-neutral-800 rounded-lg shadow p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ $topic->title }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ Str::limit($topic->content, 150) }}</p>
                                    <div class="mt-2 flex gap-3 text-xs text-gray-500 dark:text-gray-400">
                                        <span>Foro: {{ $topic->forum->name }}</span>
                                        <span>{{ $topic->views }} vistas</span>
                                        <span>{{ $topic->replies_count }} respuestas</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Noticias -->
        @if($results['news']->isNotEmpty())
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    Noticias ({{ $results['news']->count() }})
                </h3>
                <div class="space-y-3">
                    @foreach($results['news'] as $item)
                        <a href="{{ route('news.show', $item->id) }}" 
                            class="block bg-white dark:bg-neutral-800 rounded-lg shadow p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                            {{ ucfirst($item->category) }}
                                        </span>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ $item->title }}</h4>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $item->excerpt }}</p>
                                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                        {{ $item->published_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Eventos -->
        @if($results['events']->isNotEmpty())
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Eventos ({{ $results['events']->count() }})
                </h3>
                <div class="space-y-3">
                    @foreach($results['events'] as $event)
                        <div class="block bg-white dark:bg-neutral-800 rounded-lg shadow p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-3 h-3 rounded-full" style="background-color: {{ $event->color }}"></div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ $event->title }}</h4>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $event->description }}</p>
                                    <div class="mt-2 flex gap-3 text-xs text-gray-500 dark:text-gray-400">
                                        <span>{{ $event->start_date->format('d/m/Y H:i') }}</span>
                                        @if($event->location)
                                            <span>📍 {{ $event->location }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($totalResults === 0)
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <p class="mt-4 text-gray-500 dark:text-gray-400">No se encontraron resultados para "{{ $query }}"</p>
            </div>
        @endif
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <p class="mt-4 text-gray-500 dark:text-gray-400">Escribe algo para buscar en todo el portal</p>
        </div>
    @endif
</div>
