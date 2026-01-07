<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Calendario de Eventos</h2>
    </div>

    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-6">
        <!-- Controles del calendario -->
        <div class="flex items-center justify-between mb-6">
            <button wire:click="previousMonth" 
                class="bg-gray-200 hover:bg-gray-300 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-gray-800 dark:text-white font-medium py-2 px-4 rounded-md">
                ← Anterior
            </button>
            
            <div class="flex items-center gap-4">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ \Carbon\Carbon::parse($currentDate)->translatedFormat('F Y') }}
                </h3>
                <button wire:click="today" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                    Hoy
                </button>
            </div>
            
            <button wire:click="nextMonth" 
                class="bg-gray-200 hover:bg-gray-300 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-gray-800 dark:text-white font-medium py-2 px-4 rounded-md">
                Siguiente →
            </button>
        </div>

        <!-- Botón crear evento -->
        <div class="mb-4">
            <button wire:click="openCreateModal" 
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                + Crear Evento
            </button>
        </div>

        <!-- Lista de eventos del mes -->
        <div class="space-y-3">
            @foreach(\App\Models\Event::whereBetween('start_date', [\Carbon\Carbon::parse($currentDate)->startOfMonth(), \Carbon\Carbon::parse($currentDate)->endOfMonth()])->where(function($q) { $q->where('is_public', true)->orWhere('user_id', auth()->id()); })->orderBy('start_date')->get() as $event)
                <div class="border-l-4 pl-4 py-3 rounded bg-gray-50 dark:bg-neutral-700" style="border-color: {{ $event->color }}">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $event->title }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $event->description }}</p>
                            <div class="mt-2 flex gap-4 text-sm text-gray-500 dark:text-gray-400">
                                <span>📅 {{ $event->start_date->format('d/m/Y H:i') }}</span>
                                @if($event->location)
                                    <span>📍 {{ $event->location }}</span>
                                @endif
                                <span class="px-2 py-0.5 rounded-full bg-gray-200 dark:bg-neutral-600 text-xs">
                                    {{ ucfirst($event->type) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal crear evento -->
    @if($showCreateModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="closeCreateModal"></div>

                <div class="inline-block align-bottom bg-white dark:bg-neutral-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Crear Nuevo Evento</h3>

                        <form wire:submit.prevent="createEvent" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título *</label>
                                <input type="text" wire:model="title" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white">
                                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                                <textarea wire:model="description" rows="3" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white"></textarea>
                                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo *</label>
                                    <select wire:model="type" 
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white">
                                        @foreach($types as $key => $label)
                                            <option value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ubicación</label>
                                    <input type="text" wire:model="location" 
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white">
                                    @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Inicio *</label>
                                    <input type="datetime-local" wire:model="startDate" 
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white">
                                    @error('startDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Fin</label>
                                    <input type="datetime-local" wire:model="endDate" 
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white">
                                    @error('endDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" wire:model="allDay" 
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label class="ml-2 text-sm text-gray-700 dark:text-gray-300">Todo el día</label>
                            </div>

                            <div class="flex justify-end gap-3">
                                <button type="button" wire:click="closeCreateModal" 
                                    class="bg-gray-200 hover:bg-gray-300 dark:bg-neutral-600 dark:hover:bg-neutral-500 text-gray-800 dark:text-white font-medium py-2 px-4 rounded-md">
                                    Cancelar
                                </button>
                                <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                                    Crear Evento
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
