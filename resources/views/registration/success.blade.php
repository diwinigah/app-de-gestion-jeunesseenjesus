<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription envoyee</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f6f7f9; color: #172033; }
        main { min-height: 100vh; display: grid; place-items: center; padding: 24px; }
        section { width: min(100%, 560px); background: #fff; border: 1px solid #dfe3ea; border-radius: 8px; padding: 28px; text-align: center; }
        h1 { margin: 0 0 10px; font-size: clamp(1.7rem, 5vw, 2.3rem); }
        p { line-height: 1.6; color: #475467; }
        strong { display: inline-block; color: #155eef; }
    </style>
</head>
<body>
<main>
    <section>
        <h1>Inscription recue</h1>
        <p>Merci. Votre demande a bien ete envoyee.</p>
        <p>Numero d'inscription : <strong>{{ $registration }}</strong></p>
    </section>
</main>
</body>
</html>
