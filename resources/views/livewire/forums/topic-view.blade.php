<div>
    <div class="mb-6">
        <a href="{{ route('forums.topics', $topic->forum_id) }}" class="text-blue-600 hover:text-blue-700 mb-4 inline-block">
            ← Volver a {{ $topic->forum->name }}
        </a>
    </div>

    <!-- Tema principal -->
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-8 mb-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-3">
                    @if($topic->is_pinned)
                        <span class="text-yellow-500 text-xl">📌</span>
                    @endif
                    @if($topic->is_locked)
                        <span class="text-gray-500 text-xl">🔒</span>
                    @endif
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $topic->title }}</h1>
                </div>

                <div class="flex items-center gap-6 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center">
                        <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold mr-2">
                            {{ strtoupper(substr($topic->user->name, 0, 1)) }}
                        </div>
                        {{ $topic->user->name }}
                    </div>
                    <span>{{ $topic->created_at->diffForHumans() }}</span>
                    <span>{{ $topic->views }} vistas</span>
                    <span>{{ $topic->replies_count }} respuestas</span>
                </div>
            </div>
        </div>

        <div class="prose dark:prose-invert max-w-none">
            {!! nl2br(e($topic->content)) !!}
        </div>
    </div>

    <!-- Formulario de respuesta (si no está bloqueado) -->
    @if(!$topic->is_locked)
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-8 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                @if($replyingTo)
                    Respondiendo a un comentario
                @else
                    Escribe tu respuesta
                @endif
            </h3>

            <form wire:submit.prevent="submitReply" class="space-y-4">
                <div>
                    <textarea wire:model="replyContent" rows="4" placeholder="Escribe tu respuesta aquí..." 
                        class="w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                    @error('replyContent') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-between">
                    @if($replyingTo)
                        <button type="button" wire:click="cancelReply" 
                            class="bg-gray-200 hover:bg-gray-300 dark:bg-neutral-600 dark:hover:bg-neutral-500 text-gray-800 dark:text-white font-medium py-2 px-4 rounded-md">
                            Cancelar
                        </button>
                    @else
                        <div></div>
                    @endif
                    
                    <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md">
                        Publicar Respuesta
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4 mb-6">
            <p class="text-yellow-800 dark:text-yellow-200">🔒 Este tema está bloqueado y no se pueden agregar más respuestas.</p>
        </div>
    @endif

    <!-- Respuestas -->
    <div class="space-y-4">
        @forelse($replies as $reply)
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-6 
                {{ $reply->is_solution ? 'border-2 border-green-500' : '' }}">
                
                @if($reply->is_solution)
                    <div class="mb-3 flex items-center text-green-600 dark:text-green-400">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-semibold">Solución Marcada</span>
                    </div>
                @endif

                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $reply->user->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $reply->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        @if(!$topic->is_locked)
                            <button wire:click="replyTo({{ $reply->id }})" 
                                class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
                                Responder
                            </button>
                        @endif

                        @if($topic->user_id === auth()->id() && !$reply->is_solution)
                            <button wire:click="markAsSolution({{ $reply->id }})" 
                                class="text-sm text-green-600 hover:text-green-700 dark:text-green-400">
                                Marcar como Solución
                            </button>
                        @endif
                    </div>
                </div>

                <div class="prose dark:prose-invert max-w-none">
                    {!! nl2br(e($reply->content)) !!}
                </div>

                <!-- Respuestas anidadas -->
                @if($reply->replies->isNotEmpty())
                    <div class="mt-4 ml-8 space-y-3 border-l-2 border-gray-200 dark:border-neutral-700 pl-4">
                        @foreach($reply->replies as $nestedReply)
                            <div class="bg-gray-50 dark:bg-neutral-700 rounded-lg p-4">
                                <div class="flex items-start gap-3 mb-2">
                                    <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                        {{ strtoupper(substr($nestedReply->user->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $nestedReply->user->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $nestedReply->created_at->diffForHumans() }}</p>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                                            {!! nl2br(e($nestedReply->content)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                <p class="mt-4 text-gray-500 dark:text-gray-400">No hay respuestas todavía. ¡Sé el primero en responder!</p>
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $replies->links() }}
    </div>

    @if(session()->has('message'))
        <div class="fixed bottom-4 right-4 bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded-lg shadow-lg">
            {{ session('message') }}
        </div>
    @endif
</div>
