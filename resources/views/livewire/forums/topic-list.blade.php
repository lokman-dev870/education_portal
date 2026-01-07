<div>
    <div class="mb-6">
        <a href="{{ route('forums.index') }}" class="text-blue-600 hover:text-blue-700 mb-4 inline-block">
            ← Volver a Foros
        </a>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $forum->name }}</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $forum->description }}</p>
    </div>

    <div class="flex justify-between items-center mb-6">
        <input type="text" wire:model.live="search" placeholder="Buscar temas..." 
            class="w-full md:w-96 rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
        
        <button wire:click="openCreateModal" 
            class="ml-4 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md whitespace-nowrap">
            Nuevo Tema
        </button>
    </div>

    <!-- Lista de temas -->
    <div class="space-y-3">
        @forelse($topics as $topic)
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 hover:shadow-md transition-shadow">
                <a href="{{ route('forums.topic', $topic->id) }}" class="block">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                @if($topic->is_pinned)
                                    <span class="text-yellow-500">📌</span>
                                @endif
                                @if($topic->is_locked)
                                    <span class="text-gray-500">🔒</span>
                                @endif
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $topic->title }}</h3>
                            </div>
                            
                            <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                <span>Por {{ $topic->user->name }}</span>
                                <span>{{ $topic->created_at->diffForHumans() }}</span>
                                <span>{{ $topic->views }} vistas</span>
                                <span>{{ $topic->replies_count }} respuestas</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="text-center py-12 bg-white dark:bg-neutral-800 rounded-lg">
                <p class="text-gray-500 dark:text-gray-400">No hay temas en este foro</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $topics->links() }}
    </div>

    <!-- Modal crear tema -->
    @if($showCreateModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="closeCreateModal"></div>

                <div class="inline-block align-bottom bg-white dark:bg-neutral-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Crear Nuevo Tema</h3>

                        <form wire:submit.prevent="createTopic" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título *</label>
                                <input type="text" wire:model="title" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white">
                                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contenido *</label>
                                <textarea wire:model="content" rows="6" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white"></textarea>
                                @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex justify-end gap-3">
                                <button type="button" wire:click="closeCreateModal" 
                                    class="bg-gray-200 hover:bg-gray-300 dark:bg-neutral-600 dark:hover:bg-neutral-500 text-gray-800 dark:text-white font-medium py-2 px-4 rounded-md">
                                    Cancelar
                                </button>
                                <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                                    Crear Tema
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
