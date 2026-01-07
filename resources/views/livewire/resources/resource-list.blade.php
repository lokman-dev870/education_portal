<div>
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Recursos Académicos</h2>
        <livewire:resources.upload-resource />
    </div>

    <!-- Filtros y búsqueda -->
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buscar</label>
                <input type="text" wire:model.live="search" placeholder="Título, descripción..." 
                    class="w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipo</label>
                <select wire:model.live="type" class="w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos</option>
                    @foreach($types as $typeKey)
                        <option value="{{ $typeKey }}">{{ ucfirst($typeKey) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Carrera</label>
                <select wire:model.live="career" class="w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todas</option>
                    @foreach($careers as $careerOption)
                        <option value="{{ $careerOption }}">{{ $careerOption }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Materia</label>
                <input type="text" wire:model.live="subject" placeholder="Ej: Anatomía" 
                    class="w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>
    </div>

    <!-- Lista de recursos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($resources as $resource)
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <span class="inline-block px-2 py-1 text-xs rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 mb-2">
                                {{ ucfirst($resource->type) }}
                            </span>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white line-clamp-2">
                                {{ $resource->title }}
                            </h3>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-4">
                        {{ $resource->description }}
                    </p>

                    <div class="space-y-2 text-sm text-gray-500 dark:text-gray-400 mb-4">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ $resource->user->name }}
                        </div>
                        @if($resource->career)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                {{ $resource->career }}
                            </div>
                        @endif
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            {{ $resource->downloads }} descargas
                        </div>
                    </div>

                    <a href="{{ route('resources.show', $resource->id) }}" 
                        class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                        Ver Detalles
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="mt-4 text-gray-500 dark:text-gray-400">No se encontraron recursos</p>
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    <div class="mt-8">
        {{ $resources->links() }}
    </div>
</div>
