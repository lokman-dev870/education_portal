<?php

namespace App\Livewire\Messages;

use App\Models\User;
use Livewire\Component;

class MessageInbox extends Component
{
    public $selectedConversation = null;
    public $messageText = '';

    public function selectConversation($userId)
    {
        $this->selectedConversation = $userId;
    }

    public function sendMessage()
    {
        if (empty($this->messageText)) {
            return;
        }

        session()->flash('message', 'Mensaje enviado (funcionalidad en desarrollo)');
        $this->messageText = '';
    }

    public function render()
    {
        // Obtener todos los usuarios excepto el usuario actual
        $users = User::where('id', '!=', auth()->id())
            ->latest('updated_at')
            ->take(15)
            ->get();

        $conversations = $users->map(function ($user, $index) {
            $messages = [
                '¿Tienes los apuntes de anatomía?',
                'Nos vemos en la biblioteca',
                '¿A qué hora es el examen?',
                'Gracias por compartir los recursos',
                '¿Estudiamos juntos para el parcial?',
                'Vi tu publicación en el foro',
                '¿Vas a la conferencia de mañana?',
                'Necesito ayuda con bioquímica',
            ];

            return [
                'id' => $user->id,
                'user' => $user,
                'lastMessage' => $messages[$index % count($messages)],
                'timestamp' => $user->updated_at->diffForHumans(),
                'unread' => $index < 3 ? rand(1, 5) : 0,
                'online' => $index < 5,
            ];
        });

        return view('livewire.messages.message-inbox', [
            'conversations' => $conversations,
        ]);
    }
}
