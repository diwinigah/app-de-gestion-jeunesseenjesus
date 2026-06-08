<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Partenaires</title>
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
        .logo-wrapper { width: 100%; height: 160px; display: flex; align-items: center; justify-content: center; background: #f3f4f6; border-bottom: 1px solid #dfe3ea; }
        .logo { max-width: 100%; max-height: 160px; object-fit: contain; display: block; }
        .initials-badge { width: 80px; height: 80px; border-radius: 50%; background: #047857; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.5rem; }
        .content { padding: 18px; }
        .partner-name { font-weight: 700; font-size: 1.05rem; margin: 0 0 8px; }
        .partner-type { display: inline-block; padding: 4px 8px; background: #dbeafe; color: #1e40af; border-radius: 4px; font-size: .82rem; font-weight: 600; margin-bottom: 12px; }
        .description { color: #5d6678; font-size: .95rem; min-height: 48px; margin-bottom: 12px; }
        .actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 12px; }
        .button { display: inline-flex; align-items: center; justify-content: center; min-height: 40px; padding: 0 15px; border-radius: 6px; font-size: .92rem; font-weight: 700; text-decoration: none; }
        .button.primary { background: #172033; color: #fff; }
        .button.secondary { border: 1px solid #047857; color: #047857; background: #fff; }
        .button:hover { opacity: 0.85; }
        .cta-section { text-align: center; margin-top: 32px; padding: 24px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; }
        .cta-section h2 { font-size: 1.3rem; margin-bottom: 12px; }
        .cta-section p { color: #5d6678; margin-bottom: 16px; }
        @media (min-width: 700px) { .grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .grid { grid-template-columns: repeat(3, 1fr); } }
    </style>
</head>
<body>
<x-investor-navbar />

<main>
    <header>
        <div class="eyebrow">Jeunesse en Jesus</div>
        <h1>Nos partenaires</h1>
        <p class="lead">Découvrez les organisations et entreprises qui soutiennent nos initiatives et accompagnent notre mission.</p>
    </header>

    @if ($partners->isEmpty())
        <section class="empty">
            <h2>Aucun partenaire publié</h2>
            <p>Revenez bientôt pour découvrir nos partenaires.</p>
        </section>
    @else
        <section class="grid">
            @foreach ($partners as $partner)
                <article class="card">
                    <div class="logo-wrapper">
                        @if ($partner->logo_path)
                            <img src="{{ asset('storage/' . $partner->logo_path) }}" alt="{{ $partner->name }}" class="logo">
                        @else
                            <div class="initials-badge">
                                {{ substr($partner->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="content">
                        <h3 class="partner-name">{{ $partner->name }}</h3>
                        @if ($partner->type)
                            <div class="partner-type">{{ $partner->type->label() }}</div>
                        @endif
                        @if ($partner->description)
                            <p class="description">{{ $partner->description }}</p>
                        @endif
                        <div class="actions">
                            @if ($partner->website_url)
                                <a href="{{ $partner->website_url }}" target="_blank" rel="noopener noreferrer" class="button secondary">
                                    Visiter le site
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </section>
    @endif

    <section class="cta-section">
        <h2>Vous souhaitez devenir partenaire ?</h2>
        <p>Rejoignez notre réseau de partenaires et participez à notre mission auprès de la jeunesse.</p>
        <a href="{{ route('partners.request') }}" class="button primary">Demander à devenir partenaire</a>
    </section>
</main>
</body>
</html>
