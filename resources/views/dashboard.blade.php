<x-layouts.app :title="__('Dashboard')">
    <div class="py-8">
        <!-- Sección de bienvenida -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg shadow-lg p-8 mb-8 text-white">
            <h1 class="text-3xl font-bold mb-2">¡Bienvenido, {{ auth()->user()->name }}!</h1>
            <p class="text-blue-100">Portal Educativo para Estudiantes de Ciencias de la Salud</p>
        </div>

        <!-- Estadísticas rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Recursos</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ \App\Models\Resource::where('is_approved', true)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Grupos</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ \App\Models\StudyGroup::where('is_public', true)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Temas</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ \App\Models\ForumTopic::count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Eventos</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ \App\Models\Event::where('start_date', '>=', now())->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accesos rápidos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <a href="{{ route('resources.index') }}" class="bg-white dark:bg-neutral-800 rounded-lg shadow-md hover:shadow-xl transition-shadow p-6 block">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">📚 Recursos</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Apuntes y materiales</p>
                    </div>
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </a>

            <a href="{{ route('forums.index') }}" class="bg-white dark:bg-neutral-800 rounded-lg shadow-md hover:shadow-xl transition-shadow p-6 block">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">💬 Foros</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Debates y dudas</p>
                    </div>
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </a>

            <a href="{{ route('study-groups.index') }}" class="bg-white dark:bg-neutral-800 rounded-lg shadow-md hover:shadow-xl transition-shadow p-6 block">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">👥 Grupos</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Grupos de estudio</p>
                    </div>
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </a>

            <a href="{{ route('calendar.index') }}" class="bg-white dark:bg-neutral-800 rounded-lg shadow-md hover:shadow-xl transition-shadow p-6 block">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">📅 Calendario</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Eventos importantes</p>
                    </div>
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </a>

            <a href="{{ route('news.index') }}" class="bg-white dark:bg-neutral-800 rounded-lg shadow-md hover:shadow-xl transition-shadow p-6 block">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">📰 Noticias</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Novedades</p>
                    </div>
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </a>

            <a href="{{ route('profile.edit') }}" class="bg-white dark:bg-neutral-800 rounded-lg shadow-md hover:shadow-xl transition-shadow p-6 block">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">👤 Perfil</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Información personal</p>
                    </div>
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </a>
        </div>
    </div>
</x-layouts.app>
