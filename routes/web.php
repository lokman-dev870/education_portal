<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');

    // Rutas del Portal Educativo
    
    // Recursos
    Route::get('/resources', App\Livewire\Resources\ResourceList::class)->name('resources.index');
    Route::get('/resources/{id}', App\Livewire\Resources\ResourceDetail::class)->name('resources.show');
    
    // Foros
    Route::get('/forums', App\Livewire\Forums\ForumList::class)->name('forums.index');
    Route::get('/forums/{forumId}/topics', App\Livewire\Forums\TopicList::class)->name('forums.topics');
    Route::get('/forums/topics/{topicId}', App\Livewire\Forums\TopicView::class)->name('forums.topic');
    
    // Grupos de Estudio
    Route::get('/study-groups', App\Livewire\StudyGroups\StudyGroupList::class)->name('study-groups.index');
    
    // Calendario
    Route::get('/calendar', App\Livewire\Events\Calendar::class)->name('calendar.index');
    
    // Noticias
    Route::get('/news', App\Livewire\News\NewsList::class)->name('news.index');
    Route::get('/news/{id}', App\Livewire\News\NewsDetail::class)->name('news.show');
    
    // Búsqueda
    Route::get('/search', App\Livewire\Search\GlobalSearch::class)->name('search');
    
    // Perfil de estudiante
    Route::get('/profile/edit-student', App\Livewire\Profile\EditProfile::class)->name('profile.student');
});

