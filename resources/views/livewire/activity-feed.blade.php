<div>
    <div class="space-y-3">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                🔥 Actividad Reciente
            </h3>
            <button wire:click="loadActivities" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                ↻ Actualizar
            </button>
        </div>
        
        @if(empty($activities))
            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                <p>No hay actividad reciente</p>
            </div>
        @else
            <div class="space-y-2 max-h-[600px] overflow-y-auto custom-scrollbar">
                @foreach($activities as $activity)
                    <a href="{{ $activity['url'] }}" 
                       class="block p-3 rounded-lg border border-gray-200 dark:border-gray-700 
                              hover:border-{{ $activity['color'] }}-500 dark:hover:border-{{ $activity['color'] }}-500
                              hover:shadow-md transition-all duration-200
                              bg-white dark:bg-gray-800">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-{{ $activity['color'] }}-100 dark:bg-{{ $activity['color'] }}-900/20 
                                        flex items-center justify-center text-xl">
                                {{ $activity['icon'] }}
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ $activity['user'] }}</span>
                                            <span class="mx-1">{{ $activity['action'] }}</span>
                                        </p>
                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate mt-1">
                                            {{ $activity['title'] }}
                                        </h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5">
                                            {{ $activity['subtitle'] }}
                                        </p>
                                    </div>
                                    
                                    <div class="flex-shrink-0 text-right">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}
                                        </span>
                                        @if($activity['type'] === 'news' && strpos($activity['title'], 'URGENTE') !== false)
                                            <span class="inline-block px-2 py-0.5 text-xs font-semibold text-red-600 bg-red-100 dark:bg-red-900/20 dark:text-red-400 rounded-full mt-1">
                                                NUEVO
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-3 mt-2">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $activity['meta'] }}
                                    </span>
                                    
                                    @if($activity['type'] === 'forum_topic' && $activity['time']->isToday())
                                        <span class="inline-block px-2 py-0.5 text-xs font-semibold text-green-600 bg-green-100 dark:bg-green-900/20 dark:text-green-400 rounded-full">
                                            HOY
                                        </span>
                                    @endif
                                    
                                    @if($activity['type'] === 'resource' && strpos($activity['title'], '🔥') !== false)
                                        <span class="inline-block px-2 py-0.5 text-xs font-semibold text-orange-600 bg-orange-100 dark:bg-orange-900/20 dark:text-orange-400 rounded-full">
                                            POPULAR
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }
        
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4a5568;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
    </style>
</div>
