<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Investir dans {{ $project->title }}</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f6f7f9; color: #172033; }
        main { width: min(100%, 600px); margin: 0 auto; padding: 28px 16px; }
        .form-container { background: #fff; border: 1px solid #dfe3ea; border-radius: 8px; padding: 24px; }
        h1 { margin: 0 0 8px; font-size: 1.6rem; }
        .subtitle { color: #5d6678; margin-bottom: 24px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.9rem; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #dfe3ea; border-radius: 4px; font-size: 0.95rem; font-family: Arial, sans-serif; }
        input:focus, textarea:focus { outline: none; border-color: #047857; box-shadow: 0 0 0 3px rgba(4, 120, 87, 0.1); }
        .error-message { color: #dc2626; font-size: 0.85rem; margin-top: 4px; }
        .form-group.error input, .form-group.error textarea { border-color: #dc2626; }
        .button { display: inline-flex; width: 100%; align-items: center; justify-content: center; min-height: 44px; background: #047857; color: #fff; border: none; border-radius: 6px; font-size: 0.95rem; font-weight: 700; cursor: pointer; margin-top: 12px; }
        .button:hover { background: #065f46; }
        .back-link { display: inline-block; margin-bottom: 16px; color: #047857; text-decoration: none; font-weight: 600; }
        .back-link:hover { text-decoration: underline; }
        @media (max-width: 600px) { main { padding: 16px 12px; } .form-container { padding: 18px; } }
    </style>
</head>
<body>
<x-investor-navbar />

<main>
    <a href="{{ route('projects.show', ['project' => $project->slug]) }}" class="back-link">← Retour au projet</a>

    <div class="form-container">
        <h1>Investir dans ce projet</h1>
        <p class="subtitle">{{ $project->title }}</p>

        <form method="POST" action="{{ route('projects.invest', ['project' => $project->slug]) }}">
            @csrf

            <div class="form-group @error('intended_amount') error @enderror">
                <label for="intended_amount">Montant proposé (F CFA) *</label>
                <input type="number" name="intended_amount" id="intended_amount" value="{{ old('intended_amount') }}" step="1" min="1" required>
                @error('intended_amount')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group @error('message') error @enderror">
                <label for="message">Message (optionnel)</label>
                <textarea name="message" id="message" rows="4" placeholder="Partagez vos motivations ou vos conditions...">{{ old('message') }}</textarea>
                @error('message')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="button">Soumettre ma proposition</button>
        </form>
    </div>
</main>
</body>
</html>
