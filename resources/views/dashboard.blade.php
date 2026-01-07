<x-layouts.app :title="__('Dashboard')">
    <div class="py-4 md:py-8">
        <!-- Sección de bienvenida Portal Educativo -->
        <div class="bg-gradient-to-r from-blue-600 to-green-600 rounded-lg shadow-lg p-6 mb-6 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="relative z-10">
                <h1 class="text-2xl md:text-3xl font-bold mb-1">¡Hola, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-blue-50 text-sm">🚀 Bienvenido a Portal Educativo • {{ \App\Models\ForumTopic::where('created_at', '>=', now()->subDay())->count() }} nuevos temas hoy • {{ \App\Models\Resource::where('created_at', '>=', now()->subDay())->count() }} recursos frescos</p>
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

        <!-- Contenido principal centrado -->
        <div class="max-w-4xl mx-auto px-4">
            <!-- Noticias destacadas -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 mb-4">
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
            <livewire:activity-feed />
        </div>
    </div>
</x-layouts.app>
