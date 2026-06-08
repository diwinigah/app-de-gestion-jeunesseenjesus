<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\InvestorUser;
use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewInvestmentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private InvestorUser $investor,
        private Project $project,
        private float $amount,
    ) {
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouvelle proposition d\'investissement')
            ->greeting('Bonjour')
            ->line('Un nouvel investisseur a exprimé son intérêt pour l\'un de vos projets.')
            ->line('**Investisseur :** ' . $this->investor->name)
            ->line('**Organisation :** ' . ($this->investor->organization_name ?? 'Non spécifiée'))
            ->line('**Projet :** ' . $this->project->title)
            ->line('**Montant proposé :** ' . number_format($this->amount, 0, ',', ' ') . ' XOF')
            ->action('Voir la proposition', route('filament.admin.resources.investor-interests.index'))
            ->line('Merci pour votre attention.');
    }

    /**
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Nouvelle proposition d\'investissement',
            'body' => $this->investor->name . ' - ' . $this->project->title,
            'icon' => 'heroicon-o-banknotes',
            'iconColor' => 'info',
            'actions' => [
                [
                    'name' => 'view',
                    'label' => 'Voir la proposition',
                    'url' => '/admin/resources/investor-interests',
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
