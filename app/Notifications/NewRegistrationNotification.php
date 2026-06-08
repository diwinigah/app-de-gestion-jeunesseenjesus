<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRegistrationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Registration $registration,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $registration = $this->registration->loadMissing(['campEdition', 'editionSection']);

        return (new MailMessage())
            ->subject('Nouvelle inscription au camp')
            ->greeting('Bonjour,')
            ->line('Une nouvelle inscription a ete soumise.')
            ->line('Numero : ' . $registration->registration_number)
            ->line('Participant : ' . $registration->first_name . ' ' . $registration->last_name)
            ->line('Edition : ' . $registration->campEdition->name)
            ->line('Section : ' . $registration->editionSection->section->label())
            ->action('Voir les inscriptions', url('/admin/registrations'));
    }

    /**
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        $registration = $this->registration->loadMissing(['campEdition', 'editionSection']);

        return [
            'title' => 'Nouvelle inscription',
            'body' => $registration->first_name . ' ' . $registration->last_name,
            'icon' => 'heroicon-o-user-plus',
            'iconColor' => 'success',
            'actions' => [
                [
                    'name' => 'view',
                    'label' => 'Voir l\'inscription',
                    'url' => '/admin/registrations/' . $registration->id . '/edit',
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
