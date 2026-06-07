<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $project->title }}</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f6f7f9; color: #172033; }
        main { width: min(100%, 980px); margin: 0 auto; padding: 28px 16px 48px; }
        a { color: #047857; font-weight: 700; text-decoration: none; }
        h1 { margin: 0; font-size: clamp(2rem, 5vw, 3.2rem); }
        p { line-height: 1.6; }
        article { margin-top: 18px; overflow: hidden; background: #fff; border: 1px solid #dfe3ea; border-radius: 8px; box-shadow: 0 1px 3px rgba(15, 23, 42, .08); }
        img, .placeholder { width: 100%; max-height: 520px; object-fit: cover; display: block; }
        .placeholder { height: 320px; display: flex; align-items: center; justify-content: center; background: #d1fae5; color: #064e3b; font-size: 1.2rem; font-weight: 700; }
        .content { padding: 22px; }
        .funding { margin-top: 24px; padding: 18px; border: 1px solid #dfe3ea; border-radius: 8px; background: #f8fafc; }
        .funding-top { display: flex; flex-wrap: wrap; justify-content: space-between; gap: 16px; }
        .label { margin: 0 0 6px; color: #667085; font-size: .9rem; }
        .collected { margin: 0; font-size: 1.6rem; font-weight: 800; }
        .goal { margin: 0; font-size: 1.2rem; font-weight: 700; }
        .progress { height: 14px; overflow: hidden; background: #e2e8f0; border-radius: 999px; margin-top: 18px; }
        .progress span { display: block; height: 100%; background: #059669; border-radius: 999px; }
        .percentage { margin: 8px 0 0; color: #047857; font-size: .95rem; font-weight: 700; }
        .description { margin-top: 28px; }
        .description img { max-width: 100%; height: auto; }
        .invest { display: inline-flex; align-items: center; justify-content: center; min-height: 44px; margin-top: 26px; padding: 0 18px; border-radius: 6px; background: #047857; color: #fff; font-size: .95rem; font-weight: 700; }
        @media (min-width: 760px) { .content { padding: 32px; } }
    </style>
</head>
<body>
@php
    $progress = $projectService->getProgressPercentage($project);
@endphp

</head>
<body>
<x-investor-navbar />

<main>
    <a href="{{ route('projects.index') }}">Retour aux projets</a>

    <article>
        @if ($project->featured_image_path)
            <img src="{{ asset('storage/' . $project->featured_image_path) }}" alt="{{ $project->title }}">
        @else
            <div class="placeholder">Projet</div>
        @endif

        <div class="content">
            <h1>{{ $project->title }}</h1>

            <section class="funding">
                <div class="funding-top">
                    <div>
                        <p class="label">Montant collecte</p>
                        <p class="collected">{{ number_format((float) $project->funded_amount, 0, ',', ' ') }} XOF</p>
                    </div>
                    <div>
                        <p class="label">Objectif</p>
                        <p class="goal">{{ number_format((float) $project->funding_goal, 0, ',', ' ') }} XOF</p>
                    </div>
                </div>

                <div class="progress" aria-label="Progression du financement">
                    <span style="width: {{ $progress }}%"></span>
                </div>
                <p class="percentage">{{ number_format($progress, 2, ',', ' ') }} % finance</p>
                <p class="label">Collecté : {{ number_format($project->funded_amount, 0, ',', ' ') }} XOF | Objectif : {{ number_format($project->funding_goal, 0, ',', ' ') }} XOF</p>
            </section>

            <div class="description">
                {!! $project->description !!}
            </div>

            <a class="invest" href="{{ route('projects.invest.form', ['project' => $project->slug]) }}">Investir</a>
        </div>
    </article>
</main>
</body>
</html>
