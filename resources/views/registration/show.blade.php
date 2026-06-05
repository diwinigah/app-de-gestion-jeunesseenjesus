<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription au camp</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f6f7f9; color: #172033; }
        main { width: min(100%, 760px); margin: 0 auto; padding: 24px 16px 48px; }
        header { margin-bottom: 22px; }
        h1 { margin: 0 0 8px; font-size: clamp(1.7rem, 5vw, 2.4rem); }
        p { line-height: 1.55; }
        form { background: #fff; border: 1px solid #dfe3ea; border-radius: 8px; padding: 18px; }
        .grid { display: grid; grid-template-columns: 1fr; gap: 16px; }
        label { display: block; font-weight: 700; margin-bottom: 6px; }
        input, select, textarea { width: 100%; border: 1px solid #cbd3df; border-radius: 6px; padding: 11px 12px; font-size: 1rem; }
        textarea { min-height: 110px; resize: vertical; }
        .error { margin-top: 6px; color: #b42318; font-size: .92rem; }
        .alert { border: 1px solid #f2c8c4; background: #fff5f4; color: #8a1f15; border-radius: 6px; padding: 12px; margin-bottom: 16px; }
        button { width: 100%; border: 0; border-radius: 6px; background: #155eef; color: #fff; padding: 13px 16px; font-size: 1rem; font-weight: 700; cursor: pointer; }
        button:hover { background: #124ac0; }
        .hint { color: #667085; font-size: .94rem; margin-top: 4px; }
        @media (min-width: 680px) { .grid.two { grid-template-columns: repeat(2, 1fr); } }
    </style>
</head>
<body>
<main>
    <header>
        <h1>Inscription au camp</h1>
        <p>{{ $edition->name }} - inscriptions ouvertes jusqu'au {{ $edition->registration_close_at->format('d/m/Y H:i') }}.</p>
    </header>

    @if ($errors->any())
        <div class="alert">Merci de corriger les champs indiques.</div>
    @endif

    <form method="POST" action="{{ route('registration.store') }}">
        @csrf

        <div class="grid two">
            <div>
                <label for="first_name">Prenom</label>
                <input id="first_name" name="first_name" value="{{ old('first_name') }}" required autocomplete="given-name">
                @error('first_name') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="last_name">Nom</label>
                <input id="last_name" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name">
                @error('last_name') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="grid two" style="margin-top:16px">
            <div>
                <label for="gender">Genre</label>
                <select id="gender" name="gender" required>
                    <option value="">Choisir</option>
                    <option value="male" @selected(old('gender') === 'male')>Homme</option>
                    <option value="female" @selected(old('gender') === 'female')>Femme</option>
                    <option value="other" @selected(old('gender') === 'other')>Autre</option>
                </select>
                @error('gender') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="edition_section_id">Section</label>
                <select id="edition_section_id" name="edition_section_id" required>
                    <option value="">Choisir une section</option>
                    @foreach ($sections as $section)
                        <option value="{{ $section->id }}" @selected((string) old('edition_section_id') === (string) $section->id)>
                            {{ $section->section->label() }} - {{ number_format((float) $section->price, 0, ',', ' ') }} {{ $edition->currency }}
                        </option>
                    @endforeach
                </select>
                @error('edition_section_id') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="grid two" style="margin-top:16px">
            <div>
                <label for="phone">Telephone</label>
                <input id="phone" name="phone" value="{{ old('phone') }}" required autocomplete="tel">
                @error('phone') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="whatsapp_phone">WhatsApp</label>
                <input id="whatsapp_phone" name="whatsapp_phone" value="{{ old('whatsapp_phone') }}" autocomplete="tel">
                <div class="hint">Facultatif.</div>
                @error('whatsapp_phone') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div style="margin-top:16px">
            <label for="city">Ville</label>
            <input id="city" name="city" value="{{ old('city') }}" autocomplete="address-level2">
            @error('city') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div style="margin-top:20px">
            <button type="submit">Envoyer l'inscription</button>
        </div>
    </form>
</main>
</body>
</html>
