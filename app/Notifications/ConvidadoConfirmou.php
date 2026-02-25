<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Convidado;
use App\Models\Event;

class ConvidadoConfirmou extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     * * Ao adicionar 'public' antes das variáveis, o PHP já as declara
     * e atribui automaticamente para você.
     */
    public function __construct(
        public Convidado $convidado, 
        public Event $evento
    ) {}

    /**
     * Define onde a notificação será entregue.
     */
    public function via(object $notifiable): array
    {
        // Salva na tabela 'notifications' do seu banco de dados
        return ['database']; 
    }

    /**
     * Estrutura os dados que serão salvos no banco de dados.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'mensagem' => "{$this->convidado->nome} confirmou presença no evento: {$this->evento->titulo}",
            'evento_id' => $this->evento->id,
            'link' => route('events.show', $this->evento->id),
            'icone' => 'fa-user-check', // Opcional: para você usar um ícone no seu painel
        ];
    }
}