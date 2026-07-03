<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\ProjectInvestorInterest;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvestmentConfirmedNotification extends Notification
{
    public function __construct(public ProjectInvestorInterest $interest)
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
        $this->interest->loadMissing('project');

        $investorName = $notifiable->name
            ?? $notifiable->organization_name
            ?? $this->interest->manual_name
            ?? 'Investisseur';

        $amount = number_format(
            (float) ($this->interest->committed_amount ?? $this->interest->intended_amount ?? 0),
            0,
            ',',
            ' '
        );

        return (new MailMessage)
            ->subject('✅ Votre investissement a été confirmé — ' . $this->interest->project->title)
            ->greeting('Cher(e) ' . $investorName . ',')
            ->line('Nous avons le plaisir de vous confirmer que votre investissement a été **enregistré avec succès** sur la plateforme Jeunesse en Jésus.')
            ->line('---')
            ->line('**📋 Récapitulatif de votre investissement**')
            ->line('**Projet :** ' . $this->interest->project->title)
            ->line('**Montant confirmé :** ' . $amount . ' ' . ($this->interest->currency ?? 'FCFA'))
            ->line('---')
            ->line('Votre confiance et votre soutien envers ce projet sont précieux. Nous vous remercions sincèrement pour votre engagement et votre générosité.')
            ->line('Nous restons disponibles pour vous tenir informé(e) de l\'avancement du projet.')
            ->action('Accéder à mon espace investisseur', url('/investisseur/tableau-de-bord'))
            ->line('Pour toute question, n\'hésitez pas à nous contacter à **jeunesseenjesus.j2@gmail.com**.')
            ->salutation('Avec gratitude,' . PHP_EOL . '**L\'équipe Jeunesse en Jésus**');
    }
}
