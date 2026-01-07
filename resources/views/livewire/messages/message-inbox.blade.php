<div class="h-screen flex">
    <!-- Lista de conversaciones -->
    <div class="w-80 border-r border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 flex flex-col">
        <!-- Header -->
        <div class="p-4 border-b border-gray-200 dark:border-zinc-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">💌 Mensajes</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ count($conversations) }} conversaciones</p>
        </div>

        <!-- Lista de conversaciones -->
        <div class="flex-1 overflow-y-auto">
            @forelse($conversations as $conversation)
                <div wire:click="selectConversation({{ $conversation['id'] }})" 
                     class="p-4 border-b border-gray-200 dark:border-zinc-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors {{ $selectedConversation == $conversation['id'] ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                    <div class="flex items-start gap-3">
                        <div class="relative flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-semibold">
                                {{ substr($conversation['user']['name'], 0, 1) }}
                            </div>
                            @if($conversation['online'])
                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white dark:border-zinc-900 rounded-full"></span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $conversation['user']['name'] }}</p>
                                @if($conversation['unread'] > 0)
                                    <span class="ml-2 px-2 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full">{{ $conversation['unread'] }}</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 truncate mt-1">{{ $conversation['lastMessage'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $conversation['timestamp'] }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <p class="text-gray-500 dark:text-gray-400">No hay conversaciones</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Área de chat -->
    <div class="flex-1 flex flex-col bg-gray-50 dark:bg-zinc-800">
        @if($selectedConversation)
            @php
                $selected = collect($conversations)->firstWhere('id', $selectedConversation);
            @endphp
            
            <!-- Header del chat -->
            <div class="p-4 bg-white dark:bg-zinc-900 border-b border-gray-200 dark:border-zinc-700 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-semibold">
                    {{ substr($selected['user']['name'], 0, 1) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $selected['user']['name'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        @if($selected['online'])
                            <span class="text-green-500">● En línea</span>
                        @else
                            Visto {{ $selected['timestamp'] }}
                        @endif
                    </p>
                </div>
            </div>

            <!-- Mensajes -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4">
                <!-- Mensaje recibido -->
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-semibold text-xs flex-shrink-0">
                        {{ substr($selected['user']['name'], 0, 1) }}
                    </div>
                    <div class="max-w-md">
                        <div class="bg-white dark:bg-zinc-700 rounded-lg p-3 shadow-sm">
                            <p class="text-gray-900 dark:text-white">{{ $selected['lastMessage'] }}</p>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $selected['timestamp'] }}</p>
                    </div>
                </div>

                <!-- Mensaje enviado -->
                <div class="flex items-start gap-3 justify-end">
                    <div class="max-w-md">
                        <div class="bg-blue-600 rounded-lg p-3 shadow-sm">
                            <p class="text-white">¡Claro! Te los comparto ahora mismo</p>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 text-right">Hace 1 hora</p>
                    </div>
                </div>

                <!-- Más mensajes intercalados -->
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-semibold text-xs flex-shrink-0">
                        {{ substr($selected['user']['name'], 0, 1) }}
                    </div>
                    <div class="max-w-md">
                        <div class="bg-white dark:bg-zinc-700 rounded-lg p-3 shadow-sm">
                            <p class="text-gray-900 dark:text-white">¡Perfecto! Muchas gracias 🙏</p>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Hace 45 min</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 justify-end">
                    <div class="max-w-md">
                        <div class="bg-blue-600 rounded-lg p-3 shadow-sm">
                            <p class="text-white">De nada, para eso estamos 😊</p>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 text-right">Hace 40 min</p>
                    </div>
                </div>
            </div>

            <!-- Input de mensaje -->
            <div class="p-4 bg-white dark:bg-zinc-900 border-t border-gray-200 dark:border-zinc-700">
                <form wire:submit.prevent="sendMessage" class="flex gap-3">
                    <input type="text" 
                           wire:model="messageText"
                           placeholder="Escribe un mensaje..."
                           class="flex-1 px-4 py-3 rounded-lg border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Enviar
                    </button>
                </form>
            </div>
        @else
            <!-- Estado vacío -->
            <div class="flex-1 flex items-center justify-center">
                <div class="text-center">
                    <div class="text-6xl mb-4">💬</div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Tus Mensajes</h3>
                    <p class="text-gray-500 dark:text-gray-400">Selecciona una conversación para comenzar a chatear</p>
                </div>
            </div>
        @endif
    </div>
</div>
