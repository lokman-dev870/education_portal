<x-layouts.app :title="__('Dashboard')">
    <div class="py-4 md:py-8">
        <!-- Sección de bienvenida compacta -->
        <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 rounded-lg shadow-lg p-6 mb-6 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="relative z-10">
                <h1 class="text-2xl md:text-3xl font-bold mb-1">¡Hola, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-blue-100 text-sm">🔥 {{ \App\Models\ForumTopic::where('created_at', '>=', now()->subDay())->count() }} nuevos temas hoy • {{ \App\Models\Resource::where('created_at', '>=', now()->subDay())->count() }} recursos agregados</p>
            </div>
        </div>

        <!-- Estadísticas rápidas animadas -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-6">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-4 text-white transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs md:text-sm font-medium opacity-90">Recursos</p>
                        <p class="text-2xl md:text-3xl font-bold">{{ \App\Models\Resource::where('is_approved', true)->count() }}</p>
                        <p class="text-xs opacity-75 mt-1">📚 Disponibles</p>
                    </div>
                    <div class="text-4xl opacity-50">📝</div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-4 text-white transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs md:text-sm font-medium opacity-90">Grupos</p>
                        <p class="text-2xl md:text-3xl font-bold">{{ \App\Models\StudyGroup::where('is_public', true)->count() }}</p>
                        <p class="text-xs opacity-75 mt-1">👥 Activos</p>
                    </div>
                    <div class="text-4xl opacity-50">🤝</div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-4 text-white transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs md:text-sm font-medium opacity-90">Temas</p>
                        <p class="text-2xl md:text-3xl font-bold">{{ \App\Models\ForumTopic::count() }}</p>
                        <p class="text-xs opacity-75 mt-1">💬 Discusiones</p>
                    </div>
                    <div class="text-4xl opacity-50">🔥</div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg shadow-lg p-4 text-white transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs md:text-sm font-medium opacity-90">Eventos</p>
                        <p class="text-2xl md:text-3xl font-bold">{{ \App\Models\Event::where('start_date', '>=', now())->count() }}</p>
                        <p class="text-xs opacity-75 mt-1">📅 Próximos</p>
                    </div>
                    <div class="text-4xl opacity-50">⚡</div>
                </div>
            </div>
        </div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Eventos</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ \App\Models\Event::where('start_date', '>=', now())->count() }}</p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Layout de 2 columnas -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Columna principal - Feed de actividad (2/3) -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Noticias destacadas tipo carrusel -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">⭐ Destacado Ahora</h2>
                        <a href="{{ route('news.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Ver todas →</a>
                    </div>
                    
                    @php
                        $featuredNews = \App\Models\News::where('is_published', true)
                            ->where('is_featured', true)
                            ->latest('published_at')
                            ->take(3)
                            ->get();
                    @endphp
                    
                    <div class="space-y-2">
                        @foreach($featuredNews as $news)
                            <a href="{{ route('news.show', $news->id) }}" 
                               class="block p-3 bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/10 dark:to-orange-900/10 
                                      border-l-4 border-yellow-500 rounded hover:shadow-md transition-all">
                                <div class="flex items-start gap-3">
                                    <span class="text-2xl flex-shrink-0">🔥</span>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-900 dark:text-gray-100 line-clamp-1">{{ $news->title }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-1 mt-1">{{ $news->excerpt }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $news->published_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                
                <!-- Feed de Actividad -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                    <livewire:activity-feed />
                </div>
            </div>
            
            <!-- Columna lateral - Accesos rápidos y eventos (1/3) -->
            <div class="space-y-4">
                <!-- Accesos rápidos -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-3">⚡ Acceso Rápido</h3>
                    <div class="space-y-2">
                        <a href="{{ route('resources.index') }}" 
                           class="flex items-center gap-3 p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                            <span class="text-2xl">📚</span>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 dark:text-gray-100">Recursos</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ \App\Models\Resource::where('created_at', '>=', now()->subWeek())->count() }} nuevos esta semana</p>
                            </div>
                            <span class="text-blue-600 dark:text-blue-400">→</span>
                        </a>
                        
                        <a href="{{ route('forums.index') }}" 
                           class="flex items-center gap-3 p-3 rounded-lg bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
                            <span class="text-2xl">💬</span>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 dark:text-gray-100">Foros</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ \App\Models\ForumTopic::where('created_at', '>=', now()->subDay())->count() }} temas hoy</p>
                            </div>
                            <span class="text-purple-600 dark:text-purple-400">→</span>
                        </a>
                        
                        <a href="{{ route('study-groups.index') }}" 
                           class="flex items-center gap-3 p-3 rounded-lg bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                            <span class="text-2xl">👥</span>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 dark:text-gray-100">Grupos</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Únete a la comunidad</p>
                            </div>
                            <span class="text-green-600 dark:text-green-400">→</span>
                        </a>
                        
                        <a href="{{ route('calendar.index') }}" 
                           class="flex items-center gap-3 p-3 rounded-lg bg-orange-50 dark:bg-orange-900/20 hover:bg-orange-100 dark:hover:bg-orange-900/30 transition-colors">
                            <span class="text-2xl">📅</span>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 dark:text-gray-100">Calendario</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ \App\Models\Event::where('start_date', '>=', now())->where('start_date', '<=', now()->addWeek())->count() }} eventos esta semana</p>
                            </div>
                            <span class="text-orange-600 dark:text-orange-400">→</span>
                        </a>
                    </div>
                </div>
                
                <!-- Eventos próximos -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-3">📅 Próximos Eventos</h3>
                    
                    @php
                        $upcomingEvents = \App\Models\Event::where('start_date', '>=', now())
                            ->orderBy('start_date')
                            ->take(5)
                            ->get();
                    @endphp
                    
                    <div class="space-y-2">
                        @forelse($upcomingEvents as $event)
                            <div class="p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
                                <div class="flex gap-3">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-lg flex flex-col items-center justify-center text-white text-xs font-bold"
                                         style="background-color: {{ $event->color }}">
                                        <span>{{ $event->start_date->format('d') }}</span>
                                        <span class="text-[10px] opacity-75">{{ $event->start_date->format('M') }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-sm text-gray-900 dark:text-gray-100 line-clamp-1">{{ $event->title }}</h4>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                            {{ $event->start_date->format('H:i') }} • {{ $event->location }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-0.5">
                                            {{ $event->start_date->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">No hay eventos próximos</p>
                        @endforelse
                    </div>
                </div>
                
                <!-- Banner motivacional -->
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg shadow-md p-6 text-white text-center">
                    <p class="text-3xl mb-2">💪</p>
                    <p class="font-bold text-lg">¡Sigue así!</p>
                    <p class="text-sm opacity-90 mt-1">Tu dedicación te llevará lejos</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
