<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewProjectPublishedNotification extends Notification
{
    public function __construct(public Project $project)
    {
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouveau projet a financer - ' . $this->project->title)
            ->greeting('Bonjour ' . ($notifiable->name ?? $notifiable->organization_name ?? 'Investisseur') . ',')
            ->line('Un nouveau projet est disponible sur la plateforme Jeunesse en Jesus.')
            ->line('**' . $this->project->title . '**')
            ->line($this->project->summary ?? '')
            ->line('**Objectif de financement :** ' . number_format((float) $this->project->funding_goal, 0, ',', ' ') . ' ' . ($this->project->currency ?? 'FCFA'))
            ->action('Voir le projet et investir', url('/projets/' . $this->project->slug))
            ->line('Connectez-vous a votre espace investisseur pour soumettre une proposition.')
            ->salutation('L\'equipe Jeunesse en Jesus');
    }
}
