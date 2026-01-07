<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Perfil de Estudiante</h2>
        <p class="text-gray-600 dark:text-gray-400">Actualiza tu información académica y personal</p>
    </div>

    @if(session()->has('message'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-6">
        <form wire:submit.prevent="save" class="space-y-6">
            <!-- Avatar -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Foto de Perfil</label>
                <div class="flex items-center gap-4">
                    @if($avatar)
                        <img src="{{ $avatar->temporaryUrl() }}" class="h-20 w-20 rounded-full object-cover">
                    @else
                        <div class="h-20 w-20 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <input type="file" wire:model="avatar" class="text-sm text-gray-500 dark:text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100">
                        @error('avatar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Carrera -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Carrera *</label>
                <select wire:model="career" 
                    class="w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Seleccionar carrera</option>
                    @foreach($careers as $careerOption)
                        <option value="{{ $careerOption }}">{{ $careerOption }}</option>
                    @endforeach
                </select>
                @error('career') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Universidad -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Universidad</label>
                <input type="text" wire:model="university" 
                    class="w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('university') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Semestre -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Semestre</label>
                <input type="number" wire:model="semester" min="1" max="12" 
                    class="w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('semester') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Biografía -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Biografía</label>
                <textarea wire:model="bio" rows="4" 
                    class="w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Cuéntanos un poco sobre ti..."></textarea>
                @error('bio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Teléfono -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Teléfono</label>
                <input type="tel" wire:model="phone" 
                    class="w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Intereses -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Áreas de Interés</label>
                <input type="text" wire:model="interests" 
                    class="w-full rounded-md border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Cirugía, Pediatría, Investigación (separadas por comas)">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Separa las áreas con comas</p>
                @error('interests') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Botón guardar -->
            <div class="flex justify-end">
                <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md transition-colors">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
