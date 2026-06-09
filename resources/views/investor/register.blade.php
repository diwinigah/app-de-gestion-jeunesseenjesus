<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>S'inscrire - Investisseur</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f6f7f9; color: #172033; }
        main { width: min(100%, 500px); margin: 0 auto; padding: 28px 16px; }
        .form-container { background: #fff; border: 1px solid #dfe3ea; border-radius: 8px; padding: 24px; }
        h1 { margin: 0 0 24px; font-size: 1.8rem; }
        .form-group { margin-bottom: 16px; }
        label { display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.9rem; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #dfe3ea; border-radius: 4px; font-size: 0.95rem; font-family: Arial, sans-serif; }
        input:focus, textarea:focus { outline: none; border-color: #047857; box-shadow: 0 0 0 3px rgba(4, 120, 87, 0.1); }
        .error-message { color: #dc2626; font-size: 0.85rem; margin-top: 4px; }
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
        <h1>S'inscrire</h1>

        <form method="POST" action="{{ route('investor.register') }}">
            @csrf

            <div class="form-group @if ($errors->has('name') && session('_old_input')) error @endif">
                <label for="name">Nom complet *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                @if ($errors->has('name') && session('_old_input'))
                    <div class="error-message">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="form-group @if ($errors->has('organization_name') && session('_old_input')) error @endif">
                <label for="organization_name">Organisation</label>
                <input type="text" name="organization_name" id="organization_name" value="{{ old('organization_name') }}">
                @if ($errors->has('organization_name') && session('_old_input'))
                    <div class="error-message">{{ $errors->first('organization_name') }}</div>
                @endif
            </div>

            <div class="form-group @if ($errors->has('email') && session('_old_input')) error @endif">
                <label for="email">Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                @if ($errors->has('email') && session('_old_input'))
                    <div class="error-message">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <div class="form-group @if ($errors->has('phone') && session('_old_input')) error @endif">
                <label for="phone">Téléphone *</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" placeholder="+226 XX XX XX XX" required>
                @if ($errors->has('phone') && session('_old_input'))
                    <div class="error-message">{{ $errors->first('phone') }}</div>
                @endif
            </div>

            <div class="form-group @if ($errors->has('password') && session('_old_input')) error @endif">
                <label for="password">Mot de passe *</label>
                <input type="password" name="password" id="password" required>
                @if ($errors->has('password') && session('_old_input'))
                    <div class="error-message">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <div class="form-group @if ($errors->has('password_confirmation') && session('_old_input')) error @endif">
                <label for="password_confirmation">Confirmer le mot de passe *</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>
                @if ($errors->has('password_confirmation') && session('_old_input'))
                    <div class="error-message">{{ $errors->first('password_confirmation') }}</div>
                @endif
            </div>

            <button
                type="submit"
                id="submit-btn"
                class="button"
                onclick="this.disabled=true;
                         this.innerText='Envoi en cours...';
                         this.form.submit();">
                S'inscrire
            </button>
        </form>

        <div class="link">
            Vous avez déjà un compte ? <a href="{{ route('investor.login') }}">Se connecter</a>
        </div>
    </div>
</main>
</body>
</html>
