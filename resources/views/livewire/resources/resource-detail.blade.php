<div>
    <div class="mb-6">
        <a href="{{ route('resources.index') }}" class="text-blue-600 hover:text-blue-700 mb-4 inline-block">
            ← Volver a Recursos
        </a>
    </div>

    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-8 mb-6">
        <!-- Información principal -->
        <div class="flex items-start justify-between mb-6">
            <div class="flex-1">
                <span class="inline-block px-3 py-1 text-sm rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 mb-3">
                    {{ ucfirst($resource->type) }}
                </span>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $resource->title }}</h1>
                
                <div class="flex items-center gap-6 text-sm text-gray-500 dark:text-gray-400 mb-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ $resource->user->name }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $resource->created_at->diffForHumans() }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        {{ $resource->downloads }} descargas
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="w-6 h-6 {{ $i <= round($resource->averageRating()) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                @endfor
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">({{ round($resource->averageRating(), 1) }})</span>
            </div>
        </div>

        <p class="text-gray-700 dark:text-gray-300 mb-6">{{ $resource->description }}</p>

        <!-- Detalles del recurso -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 p-4 bg-gray-50 dark:bg-neutral-700 rounded-lg">
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Carrera</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $resource->career }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Materia</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $resource->subject }}</p>
            </div>
            @if($resource->semester)
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Semestre</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $resource->semester }}°</p>
                </div>
            @endif
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Tamaño</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ number_format($resource->file_size / 1024 / 1024, 2) }} MB</p>
            </div>
        </div>

        <!-- Etiquetas -->
        @if($resource->tags && count($resource->tags) > 0)
            <div class="mb-6">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Etiquetas:</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($resource->tags as $tag)
                        <span class="px-3 py-1 text-sm rounded-full bg-gray-200 dark:bg-neutral-600 text-gray-700 dark:text-gray-300">
                            {{ $tag }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Botón de descarga -->
        <button wire:click="download" 
            class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-md transition-colors flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            Descargar {{ strtoupper($resource->file_type) }}
        </button>
    </div>

    <!-- Valoraciones -->
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-8">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Valoraciones y Comentarios</h3>

        <!-- Formulario de valoración -->
        @if(!$userRating)
            <div class="mb-8 p-6 bg-gray-50 dark:bg-neutral-700 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white mb-4">Deja tu valoración</h4>
                <form wire:submit.prevent="submitRating" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Calificación</label>
                        <div class="flex gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" wire:click="$set('rating', {{ $i }})"
                                    class="text-3xl {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-300' }} hover:text-yellow-400 transition-colors">
                                    ★
                                </button>
                            @endfor
                        </div>
                        @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Comentario (opcional)</label>
                        <textarea wire:model="comment" rows="3" 
                            class="w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-600 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md">
                        Enviar Valoración
                    </button>
                </form>
            </div>
        @else
            <div class="mb-8 p-6 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg">
                <p class="text-green-800 dark:text-green-200">✓ Ya has valorado este recurso</p>
            </div>
        @endif

        <!-- Lista de valoraciones -->
        <div class="space-y-4">
            @forelse($resource->ratings()->with('user')->latest()->get() as $rating)
                <div class="border-b border-gray-200 dark:border-neutral-700 pb-4">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr($rating->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $rating->user->name }}</p>
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="text-{{ $i <= $rating->rating ? 'yellow' : 'gray' }}-400">★</span>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $rating->created_at->diffForHumans() }}</span>
                    </div>
                    @if($rating->comment)
                        <p class="text-gray-700 dark:text-gray-300 ml-13">{{ $rating->comment }}</p>
                    @endif
                </div>
            @empty
                <p class="text-center text-gray-500 dark:text-gray-400 py-8">No hay valoraciones todavía</p>
            @endforelse
        </div>
    </div>
</div>
