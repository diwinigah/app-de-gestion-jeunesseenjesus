<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tableau de bord - Investisseur</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f6f7f9; color: #172033; }
        main { width: min(100%, 1000px); margin: 0 auto; padding: 28px 16px; }
        h1 { margin: 0 0 24px; font-size: 1.8rem; }
        .empty { background: #fff; border: 1px solid #dfe3ea; border-radius: 8px; padding: 22px; text-align: center; }
        .table-container { background: #fff; border: 1px solid #dfe3ea; border-radius: 8px; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f3f4f6; padding: 12px 16px; text-align: left; font-weight: 700; font-size: 0.9rem; border-bottom: 1px solid #dfe3ea; }
        td { padding: 12px 16px; border-bottom: 1px solid #dfe3ea; font-size: 0.95rem; }
        tr:last-child td { border-bottom: none; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 999px; font-size: 0.8rem; font-weight: 700; }
        .badge-new { background: #dbeafe; color: #1e40af; }
        .badge-contacted { background: #fef3c7; color: #92400e; }
        .badge-pledged { background: #d1fae5; color: #065f46; }
        .badge-paid { background: #d1fae5; color: #065f46; }
        .badge-cancelled { background: #fee2e2; color: #7f1d1d; }
        .actions { margin-top: 20px; }
        .button { display: inline-flex; align-items: center; justify-content: center; min-height: 40px; padding: 0 16px; border-radius: 6px; font-size: 0.9rem; font-weight: 700; text-decoration: none; background: #172033; color: #fff; border: none; cursor: pointer; }
        .button:hover { background: #0d1520; }
        .success-message { background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; }
        @media (max-width: 600px) { main { padding: 16px 12px; } table { font-size: 0.85rem; } th, td { padding: 8px 12px; } }
    </style>
</head>
<body>
<x-investor-navbar />

<main>
    <h1>Mes investissements</h1>

    @if (session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    @if ($investments->isEmpty())
        <div class="empty">
            <p>Vous n'avez pas encore exprimé d'intérêt d'investissement.</p>
            <a href="{{ route('projects.index') }}" class="button" style="margin-top: 12px;">Découvrir les projets</a>
        </div>
    @else
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Projet</th>
                        <th>Montant proposé</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($investments as $investment)
                        <tr>
                            <td>
                                <strong>{{ $investment->project->title }}</strong>
                            </td>
                            <td>
                                {{ number_format((float) $investment->intended_amount, 0, ',', ' ') }} XOF
                            </td>
                            <td>
                                <span class="badge badge-{{ $investment->status->value }}">
                                    @switch($investment->status->value)
                                        @case('new')
                                            Nouvelle
                                            @break
                                        @case('contacted')
                                            Contacté
                                            @break
                                        @case('pledged')
                                            Engagé
                                            @break
                                        @case('paid')
                                            Payé
                                            @break
                                        @case('cancelled')
                                            Annulé
                                            @break
                                    @endswitch
                                </span>
                            </td>
                            <td>
                                {{ $investment->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="actions">
            <a href="{{ route('projects.index') }}" class="button">Voir d'autres projets</a>
        </div>
    @endif
</main>
</body>
</html>
