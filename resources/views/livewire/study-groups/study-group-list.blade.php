<div>
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Grupos de Estudio</h2>
        <button wire:click="openCreateModal" 
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
            Crear Grupo
        </button>
    </div>

    <!-- Filtros -->
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buscar</label>
                <input type="text" wire:model.live="search" placeholder="Nombre o materia..." 
                    class="w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
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
        </div>
    </div>

    <!-- Lista de grupos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($groups as $group)
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $group->name }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-4">{{ $group->description }}</p>

                    <div class="space-y-2 text-sm text-gray-500 dark:text-gray-400 mb-4">
                        @if($group->subject)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                {{ $group->subject }}
                            </div>
                        @endif
                        @if($group->career)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                {{ $group->career }}
                            </div>
                        @endif
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            {{ $group->members->count() }} / {{ $group->max_members }} miembros
                        </div>
                    </div>

                    @if(!$group->isMember(auth()->user()))
                        <button wire:click="joinGroup({{ $group->id }})" 
                            @if($group->isFull()) disabled @endif
                            class="block w-full text-center {{ $group->isFull() ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700' }} text-white font-medium py-2 px-4 rounded-md transition-colors">
                            {{ $group->isFull() ? 'Grupo Lleno' : 'Unirse al Grupo' }}
                        </button>
                    @else
                        <div class="block w-full text-center bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 font-medium py-2 px-4 rounded-md">
                            ✓ Miembro
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p class="mt-4 text-gray-500 dark:text-gray-400">No se encontraron grupos de estudio</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $groups->links() }}
    </div>

    <!-- Modal crear grupo -->
    @if($showCreateModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="closeCreateModal"></div>

                <div class="inline-block align-bottom bg-white dark:bg-neutral-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Crear Grupo de Estudio</h3>

                        <form wire:submit.prevent="createGroup" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre *</label>
                                <input type="text" wire:model="name" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white">
                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                                <textarea wire:model="description" rows="3" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white"></textarea>
                                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Materia *</label>
                                    <input type="text" wire:model="subject" 
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white">
                                    @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Carrera *</label>
                                    <select wire:model="groupCareer" 
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white">
                                        <option value="">Seleccionar</option>
                                        @foreach($careers as $careerOption)
                                            <option value="{{ $careerOption }}">{{ $careerOption }}</option>
                                        @endforeach
                                    </select>
                                    @error('groupCareer') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Máximo de Miembros *</label>
                                    <input type="number" wire:model="maxMembers" min="2" max="50" 
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white">
                                    @error('maxMembers') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Enlace de Reunión</label>
                                    <input type="url" wire:model="meetingLink" placeholder="https://meet.google.com/..." 
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white">
                                    @error('meetingLink') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" wire:model="isPublic" 
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label class="ml-2 text-sm text-gray-700 dark:text-gray-300">Grupo público (visible para todos)</label>
                            </div>

                            <div class="flex justify-end gap-3">
                                <button type="button" wire:click="closeCreateModal" 
                                    class="bg-gray-200 hover:bg-gray-300 dark:bg-neutral-600 dark:hover:bg-neutral-500 text-gray-800 dark:text-white font-medium py-2 px-4 rounded-md">
                                    Cancelar
                                </button>
                                <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                                    Crear Grupo
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
