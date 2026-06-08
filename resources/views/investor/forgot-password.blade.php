<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mot de passe oublié - Investisseur</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f6f7f9; color: #172033; }
        main { width: min(100%, 500px); margin: 0 auto; padding: 28px 16px; }
        .form-container { background: #fff; border: 1px solid #dfe3ea; border-radius: 8px; padding: 24px; }
        h1 { margin: 0 0 12px; font-size: 1.8rem; }
        .subtitle { color: #6b7280; margin-bottom: 24px; font-size: 0.95rem; }
        .form-group { margin-bottom: 16px; }
        label { display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.9rem; }
        input { width: 100%; padding: 10px; border: 1px solid #dfe3ea; border-radius: 4px; font-size: 0.95rem; font-family: Arial, sans-serif; }
        input:focus { outline: none; border-color: #047857; box-shadow: 0 0 0 3px rgba(4, 120, 87, 0.1); }
        .error-message { color: #dc2626; font-size: 0.85rem; margin-top: 4px; }
        .success-message { background: #d1fae5; color: #065f46; padding: 12px; border-radius: 4px; margin-bottom: 16px; font-size: 0.9rem; }
        .form-group.error input { border-color: #dc2626; }
        .button { display: inline-flex; width: 100%; align-items: center; justify-content: center; min-height: 44px; background: #172033; color: #fff; border: none; border-radius: 6px; font-size: 0.95rem; font-weight: 700; cursor: pointer; margin-top: 12px; }
        .button:hover { background: #0d1520; }
        .link { text-align: center; margin-top: 16px; }
        .link a { color: #047857; text-decoration: none; font-weight: 600; }
        @media (max-width: 600px) { main { padding: 16px 12px; } .form-container { padding: 18px; } }
    </style>
</head>
<body>
<x-investor-navbar />

<main>
    <div class="form-container">
        <h1>Mot de passe oublié</h1>
        <p class="subtitle">Entrez votre adresse email pour recevoir un lien de réinitialisation.</p>

        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (session('status'))
            <div class="success-message">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('investor.password.email') }}">
            @csrf

            <div class="form-group @error('email') error @enderror">
                <label for="email">Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="button">Envoyer le lien</button>
        </form>

        <div class="link">
            <a href="{{ route('investor.login') }}">Retour à la connexion</a>
        </div>
    </div>
</main>
</body>
</html>
