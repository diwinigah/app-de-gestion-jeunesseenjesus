<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projets a financer</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f6f7f9; color: #172033; }
        main { width: min(100%, 1180px); margin: 0 auto; padding: 28px 16px 48px; }
        header { margin-bottom: 24px; }
        h1 { margin: 6px 0 10px; font-size: clamp(1.9rem, 5vw, 3rem); }
        h2 { margin: 0; font-size: 1.2rem; }
        p { line-height: 1.55; }
        .eyebrow { color: #047857; font-size: .82rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; }
        .lead { max-width: 680px; color: #5d6678; }
        .empty, .card { background: #fff; border: 1px solid #dfe3ea; border-radius: 8px; }
        .empty { padding: 22px; }
        .grid { display: grid; grid-template-columns: 1fr; gap: 18px; }
        .card { overflow: hidden; box-shadow: 0 1px 3px rgba(15, 23, 42, .08); }
        .card img, .placeholder { width: 100%; height: 210px; object-fit: cover; display: block; }
        .placeholder { display: flex; align-items: center; justify-content: center; background: #d1fae5; color: #064e3b; font-weight: 700; }
        .content { padding: 18px; }
        .summary { color: #5d6678; font-size: .95rem; min-height: 64px; }
        .amounts { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: 18px; font-weight: 700; font-size: .92rem; }
        .progress { height: 12px; overflow: hidden; background: #e2e8f0; border-radius: 999px; margin-top: 8px; }
        .progress span { display: block; height: 100%; background: #059669; border-radius: 999px; }
        .goal { margin: 8px 0 0; color: #667085; font-size: .82rem; }
        .actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 18px; }
        .button { display: inline-flex; align-items: center; justify-content: center; min-height: 40px; padding: 0 15px; border-radius: 6px; font-size: .92rem; font-weight: 700; text-decoration: none; }
        .button.primary { background: #172033; color: #fff; }
        .button.secondary { border: 1px solid #047857; color: #047857; background: #fff; }
        .pagination { margin-top: 24px; }
        @media (min-width: 700px) { .grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .grid { grid-template-columns: repeat(3, 1fr); } }
    </style>
</head>
<body>
<main>
    <header>
        <div class="eyebrow">Jeunesse en Jesus</div>
        <h1>Projets a financer</h1>
        <p class="lead">Decouvrez les projets publies et accompagnez ceux qui construisent l'avenir de l'organisation.</p>
    </header>

    @if ($projects->isEmpty())
        <section class="empty">
            <h2>Aucun projet publie</h2>
            <p>Les projets a financer seront affiches ici des leur publication.</p>
        </section>
    @else
        <section class="grid">
            @foreach ($projects as $project)
                @php
                    $progress = $projectService->getProgressPercentage($project);
                @endphp

                <article class="card">
                    @if ($project->featured_image_path)
                        <img src="{{ asset('storage/' . $project->featured_image_path) }}" alt="{{ $project->title }}">
                    @else
                        <div class="placeholder">Projet</div>
                    @endif

                    <div class="content">
                        <h2>{{ $project->title }}</h2>
                        <p class="summary">{{ $project->summary }}</p>

                        <div class="amounts">
                            <span>{{ number_format((float) $project->funded_amount, 0, ',', ' ') }} XOF</span>
                            <span>{{ number_format($progress, 2, ',', ' ') }} %</span>
                        </div>
                        <div class="progress" aria-label="Progression du financement">
                            <span style="width: {{ $progress }}%"></span>
                        </div>
                        <p class="goal">Collecté : {{ number_format($project->funded_amount, 0, ',', ' ') }} XOF | Objectif : {{ number_format($project->funding_goal, 0, ',', ' ') }} XOF</p>

                        <div class="actions">
                            <a class="button primary" href="{{ route('projects.show', ['project' => $project->slug]) }}">Voir</a>
                            <a class="button secondary" href="/projets/{{ $project->slug }}/investir">Investir</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>

        <div class="pagination">
            {{ $projects->links() }}
        </div>
    @endif
</main>
</body>
</html>
