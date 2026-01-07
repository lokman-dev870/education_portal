<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        @php
            $newMessagesCount = 5;
        @endphp
        
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                </flux:navlist.group>
                
                <flux:navlist.group :heading="__('Portal Educativo')" class="grid">
                    <flux:navlist.item :href="route('resources.index')" :current="request()->routeIs('resources.*')" wire:navigate>📚 Recursos</flux:navlist.item>
                    <flux:navlist.item :href="route('forums.index')" :current="request()->routeIs('forums.*')" wire:navigate>💬 Foros</flux:navlist.item>
                    <flux:navlist.item :href="route('study-groups.index')" :current="request()->routeIs('study-groups.*')" wire:navigate>👥 Grupos</flux:navlist.item>
                    <flux:navlist.item :href="route('calendar.index')" :current="request()->routeIs('calendar.*')" wire:navigate>📅 Calendario</flux:navlist.item>
                    <flux:navlist.item :href="route('news.index')" :current="request()->routeIs('news.*')" wire:navigate>📰 Noticias</flux:navlist.item>
                    <flux:navlist.item :href="route('search')" :current="request()->routeIs('search')" wire:navigate>🔍 Buscar</flux:navlist.item>
                    <flux:navlist.item :href="route('messages.index')" :current="request()->routeIs('messages.*')" wire:navigate>
                        <div class="flex items-center justify-between w-full">
                            <span>💌 Mensajes</span>
                            @if($newMessagesCount > 0)
                                <span class="ml-2 px-2 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full animate-pulse">{{ $newMessagesCount }}</span>
                            @endif
                        </div>
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="user" :href="route('profile.edit')" :current="request()->routeIs('profile.*')" wire:navigate>
                {{ __('Mi Perfil') }}
                </flux:navlist.item>
            </flux:navlist>

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                    data-test="sidebar-menu-button"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <!-- Notificaciones en vivo -->
        <livewire:live-notifications />

        <!-- Layout tipo Facebook: sidebar izquierdo fijo, contenido central scrollable, sidebar derecho fijo -->
        <div class="flex fixed inset-0 lg:left-64">
            <!-- Contenido central scrollable -->
            <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-zinc-800">
                <div class="max-w-[1400px] mx-auto">
                    {{ $slot }}
                </div>
            </main>
            
            <!-- Sidebar derecho fijo -->
            <aside class="hidden xl:block w-80 border-l border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-y-auto flex-shrink-0">
                <div class="p-4 space-y-4">
                    <!-- Tendencias -->
                    <div class="pt-4 border-t border-gray-200 dark:border-zinc-700">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center gap-2">
                            🔥 Tendencias
                        </h3>
                        <div class="space-y-3">
                            @php
                                $trendingTopics = \App\Models\ForumTopic::withCount('replies')
                                    ->orderBy('replies_count', 'desc')
                                    ->take(5)
                                    ->get();
                            @endphp
                            @foreach($trendingTopics as $topic)
                                <a href="{{ route('forums.topic', $topic->id) }}" 
                                   class="block p-3 rounded-lg bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/10 dark:to-red-900/10 hover:shadow-md transition-all">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100 line-clamp-2">{{ $topic->title }}</p>
                                    <div class="flex items-center gap-3 mt-2 text-xs text-gray-600 dark:text-gray-400">
                                        <span>💬 {{ $topic->replies_count }} respuestas</span>
                                        <span>👁️ {{ $topic->views }} vistas</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Sugerencias -->
                    <div class="pt-4 border-t border-gray-200 dark:border-zinc-700">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center gap-2">
                            ✨ Sugerencias
                        </h3>
                        <div class="space-y-3">
                            @php
                                $suggestedGroups = \App\Models\StudyGroup::where('is_public', true)
                                    ->withCount('members')
                                    ->orderBy('members_count', 'desc')
                                    ->take(4)
                                    ->get();
                            @endphp
                            @foreach($suggestedGroups as $group)
                                <div class="p-3 rounded-lg border border-gray-200 dark:border-zinc-700 hover:shadow-md transition-shadow">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-green-500 to-teal-500 flex items-center justify-center text-white font-bold text-lg">
                                            👥
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 line-clamp-1">{{ $group->name }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $group->members_count }} miembros</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('study-groups.index') }}" 
                                       class="mt-3 w-full block text-center py-1.5 px-3 text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 rounded hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                                        Unirse
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Estadísticas rápidas -->
                    <div class="pt-4 border-t border-gray-200 dark:border-zinc-700">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3">📊 Hoy en el Portal</h3>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between p-2 rounded bg-gray-50 dark:bg-zinc-800">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Nuevos recursos</span>
                                <span class="font-bold text-blue-600 dark:text-blue-400">{{ \App\Models\Resource::whereDate('created_at', today())->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between p-2 rounded bg-gray-50 dark:bg-zinc-800">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Temas activos</span>
                                <span class="font-bold text-purple-600 dark:text-purple-400">{{ \App\Models\ForumTopic::whereDate('created_at', today())->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between p-2 rounded bg-gray-50 dark:bg-zinc-800">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Respuestas</span>
                                <span class="font-bold text-green-600 dark:text-green-400">{{ \App\Models\ForumReply::whereDate('created_at', today())->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>

        @fluxScripts
    </body>
</html>
