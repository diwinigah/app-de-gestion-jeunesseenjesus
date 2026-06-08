<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirmation - Demande de partenariat</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f6f7f9; color: #172033; }
        main { width: min(100%, 600px); margin: 0 auto; padding: 28px 16px 48px; }
        header { margin-bottom: 24px; }
        .success-box { background: #dcfce7; border: 1px solid #86efac; border-radius: 8px; padding: 32px 24px; text-align: center; }
        .success-icon { font-size: 3rem; margin-bottom: 16px; }
        h1 { margin: 0 0 12px; font-size: 1.8rem; color: #166534; }
        p { line-height: 1.55; color: #5d6678; margin: 12px 0; }
        .highlight { color: #166534; font-weight: 700; }
        .actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 24px; justify-content: center; }
        .button { display: inline-flex; align-items: center; justify-content: center; min-height: 44px; padding: 0 24px; border: none; border-radius: 6px; font-size: .95rem; font-weight: 700; text-decoration: none; cursor: pointer; }
        .button.primary { background: #172033; color: #fff; }
        .button.primary:hover { background: #0f1620; }
        .button.secondary { background: #fff; color: #172033; border: 1px solid #dfe3ea; }
        .button.secondary:hover { background: #f9fafb; }
    </style>
</head>
<body>

<main>
    <section class="success-box">
        <div class="success-icon">✓</div>
        <h1>Demande reçue !</h1>
        <p>Merci de votre intérêt pour devenir partenaire de <span class="highlight">Jeunesse en Jésus</span>.</p>
        <p>Votre demande a été enregistrée avec succès. Notre équipe examinera votre demande et vous <span class="highlight">contactera bientôt</span> aux coordonnées que vous avez fournies.</p>
        <p>En attendant, n'hésitez pas à explorer nos projets et notre communauté.</p>

        <div class="actions">
            <a href="{{ route('partners.index') }}" class="button primary">
                Retour aux partenaires
            </a>
            <a href="{{ route('projects.index') }}" class="button secondary">
                Découvrir nos projets
            </a>
        </div>
    </section>
</main>
</body>
</html>
