<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des inscrits - {{ $edition->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            color: #172033;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        header {
            background: white;
            border-radius: 8px;
            padding: 24px 20px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            font-size: clamp(1.5rem, 5vw, 2rem);
            margin-bottom: 8px;
            color: #155eef;
        }

        header p {
            color: #475467;
            font-size: 0.95rem;
        }

        .table-wrapper {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f3f4f6;
            padding: 16px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 0.875rem;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 16px 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.9375rem;
        }

        tr:hover {
            background: #f9fafb;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.8125rem;
            font-weight: 500;
            white-space: nowrap;
        }

        .badge-paid {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-partial {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-unpaid {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-confirmed {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
            flex-wrap: wrap;
        }

        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            background: white;
            color: #155eef;
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .pagination a:hover {
            background: #155eef;
            color: white;
        }

        .pagination span.active {
            background: #155eef;
            color: white;
            border-color: #155eef;
        }

        .pagination span:not(.active) {
            color: #6b7280;
        }

        .empty {
            text-align: center;
            padding: 40px 20px;
            color: #6b7280;
        }

        .empty-icon {
            font-size: 3rem;
            margin-bottom: 16px;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            body {
                padding: 12px;
            }

            header {
                padding: 16px;
                margin-bottom: 16px;
            }

            header h1 {
                font-size: 1.25rem;
                margin-bottom: 4px;
            }

            header p {
                font-size: 0.875rem;
            }

            table {
                font-size: 0.8125rem;
            }

            th {
                padding: 12px 8px;
                font-size: 0.75rem;
            }

            td {
                padding: 12px 8px;
                font-size: 0.875rem;
            }

            .badge {
                padding: 3px 8px;
                font-size: 0.75rem;
            }

            /* Réduire les colonnes sur mobile */
            .hidden-sm {
                display: none;
            }
        }

        @media (max-width: 640px) {
            table {
                font-size: 0.75rem;
            }

            th, td {
                padding: 8px 6px;
            }

            .badge {
                padding: 2px 6px;
                font-size: 0.7rem;
            }
        }

        .no-results {
            text-align: center;
            padding: 60px 20px;
        }

        .no-results-icon {
            font-size: 4rem;
            margin-bottom: 16px;
            color: #d1d5db;
        }

        .no-results p {
            color: #6b7280;
            font-size: 1rem;
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <h1>{{ $edition->name }}</h1>
        <p>Liste des inscrits</p>
    </header>

    @if($registrations->count() > 0)
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th class="hidden-sm">Ville</th>
                        <th class="hidden-sm">Section</th>
                        <th>Paiement</th>
                        <th class="hidden-sm">Inscription</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrations as $registration)
                        <tr>
                            <td>{{ $registration->last_name }}</td>
                            <td>{{ $registration->first_name }}</td>
                            <td class="hidden-sm">{{ $registration->city ?? '—' }}</td>
                            <td class="hidden-sm">{{ $registration->editionSection?->section ?? '—' }}</td>
                            <td>
                                <span class="badge badge-{{ strtolower($registration->payment_status?->value ?? '') }}">
                                    @switch($registration->payment_status?->value)
                                        @case('paid')
                                            Payé
                                        @break
                                        @case('partial')
                                            Partiellement payé
                                        @break
                                        @case('unpaid')
                                            Non payé
                                        @break
                                        @default
                                            —
                                    @endswitch
                                </span>
                            </td>
                            <td class="hidden-sm">
                                <span class="badge badge-{{ strtolower($registration->registration_status?->value ?? '') }}">
                                    @switch($registration->registration_status?->value)
                                        @case('confirmed')
                                            Confirmée
                                        @break
                                        @case('pending')
                                            En attente
                                        @break
                                        @case('cancelled')
                                            Annulée
                                        @break
                                        @default
                                            —
                                    @endswitch
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($registrations->hasPages())
            <div class="pagination">
                {{-- Previous Page Link --}}
                @if($registrations->onFirstPage())
                    <span>← Précédent</span>
                @else
                    <a href="{{ $registrations->previousPageUrl() }}">← Précédent</a>
                @endif

                {{-- Pagination Elements --}}
                @foreach($registrations->getUrlRange(1, $registrations->lastPage()) as $page => $url)
                    @if($page == $registrations->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if($registrations->hasMorePages())
                    <a href="{{ $registrations->nextPageUrl() }}">Suivant →</a>
                @else
                    <span>Suivant →</span>
                @endif
            </div>
        @endif
    @else
        <div class="table-wrapper">
            <div class="no-results">
                <div class="no-results-icon">📋</div>
                <p>Aucune inscription pour cette édition.</p>
            </div>
        </div>
    @endif
</div>
</body>
</html>
