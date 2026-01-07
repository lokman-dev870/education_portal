<div>
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Foros de Discusión</h2>

    <div class="space-y-4">
        @forelse($forums as $forum)
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <a href="{{ route('forums.topics', $forum->id) }}" class="block">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                @if($forum->icon)
                                    <span class="text-2xl">{{ $forum->icon }}</span>
                                @endif
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $forum->name }}</h3>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 mb-3">{{ $forum->description }}</p>
                            
                            <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                <span>{{ $forum->topics_count }} temas</span>
                                <span>{{ $forum->posts_count }} respuestas</span>
                            </div>

                            @if($forum->latest_topic)
                                <div class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                                    Último tema: <span class="font-medium">{{ Str::limit($forum->latest_topic->title, 50) }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>
            </div>
        @empty
            <div class="text-center py-12">
                <p class="text-gray-500 dark:text-gray-400">No hay foros disponibles</p>
            </div>
        @endforelse
    </div>
</div>
