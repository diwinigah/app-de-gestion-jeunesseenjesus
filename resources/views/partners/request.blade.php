<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demande de partenariat</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f6f7f9; color: #172033; }
        main { width: min(100%, 600px); margin: 0 auto; padding: 28px 16px 48px; }
        header { margin-bottom: 24px; }
        h1 { margin: 6px 0 10px; font-size: clamp(1.6rem, 4vw, 2.2rem); }
        p { line-height: 1.55; color: #5d6678; }
        .form-container { background: #fff; border: 1px solid #dfe3ea; border-radius: 8px; padding: 24px; box-shadow: 0 1px 3px rgba(15, 23, 42, .08); }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: 700; margin-bottom: 6px; font-size: .95rem; }
        input, textarea, select { width: 100%; padding: 10px 12px; border: 1px solid #dfe3ea; border-radius: 6px; font-family: inherit; font-size: .95rem; }
        input:focus, textarea:focus, select:focus { outline: none; border-color: #047857; box-shadow: 0 0 0 3px rgba(4, 120, 87, .1); }
        textarea { resize: vertical; min-height: 120px; }
        .required { color: #dc2626; }
        .error-message { color: #dc2626; font-size: .85rem; margin-top: 4px; }
        .field-error { border-color: #dc2626; }
        .field-error:focus { box-shadow: 0 0 0 3px rgba(220, 38, 38, .1); }
        .helper-text { color: #667085; font-size: .85rem; margin-top: 4px; }
        .form-row { display: grid; grid-template-columns: 1fr; gap: 20px; }
        @media (min-width: 600px) {
            .form-row { grid-template-columns: 1fr 1fr; }
        }
        .button { display: inline-flex; align-items: center; justify-content: center; min-height: 44px; padding: 0 24px; border: none; border-radius: 6px; font-size: .95rem; font-weight: 700; text-decoration: none; cursor: pointer; }
        .button.primary { background: #172033; color: #fff; width: 100%; }
        .button.primary:hover { background: #0f1620; }
        .button.secondary { background: #f3f4f6; color: #172033; border: 1px solid #dfe3ea; }
        .button.secondary:hover { background: #e5e7eb; }
        .button-group { display: flex; gap: 12px; margin-top: 24px; }
        .success-message { background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 12px; border-radius: 6px; margin-bottom: 16px; }
    </style>
</head>
<body>
<x-investor-navbar />

<main>
    <header>
        <h1>Devenir partenaire</h1>
        <p>Remplissez le formulaire ci-dessous pour soumettre votre demande de partenariat. Notre équipe examinera votre demande et vous contactera bientôt.</p>
    </header>

    <section class="form-container">
        @if ($errors->any())
            <div class="success-message" style="background: #fee2e2; border-color: #fecaca; color: #991b1b;">
                <strong>Erreurs détectées :</strong>
                <ul style="margin: 8px 0 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('partners.store') }}" novalidate>
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="contact_name">
                        Nom du contact
                        <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="contact_name"
                        name="contact_name"
                        value="{{ old('contact_name') }}"
                        placeholder="Jean Dupont"
                        required
                        class="{{ $errors->has('contact_name') ? 'field-error' : '' }}"
                    >
                    @if ($errors->has('contact_name'))
                        <div class="error-message">{{ $errors->first('contact_name') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="organization_name">
                        Nom de l'organisation
                        <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="organization_name"
                        name="organization_name"
                        value="{{ old('organization_name') }}"
                        placeholder="Acme Corporation"
                        required
                        class="{{ $errors->has('organization_name') ? 'field-error' : '' }}"
                    >
                    @if ($errors->has('organization_name'))
                        <div class="error-message">{{ $errors->first('organization_name') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">
                        Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="contact@example.com"
                        class="{{ $errors->has('email') ? 'field-error' : '' }}"
                    >
                    @if ($errors->has('email'))
                        <div class="error-message">{{ $errors->first('email') }}</div>
                    @endif
                    <div class="helper-text">Optionnel</div>
                </div>

                <div class="form-group">
                    <label for="phone">
                        Téléphone
                        <span class="required">*</span>
                    </label>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="+221 77 123 45 67"
                        required
                        class="{{ $errors->has('phone') ? 'field-error' : '' }}"
                    >
                    @if ($errors->has('phone'))
                        <div class="error-message">{{ $errors->first('phone') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="type">
                        Type d'organisation
                    </label>
                    <select
                        id="type"
                        name="type"
                        class="{{ $errors->has('type') ? 'field-error' : '' }}"
                    >
                        <option value="">-- Sélectionner --</option>
                        <option value="church" {{ old('type') === 'church' ? 'selected' : '' }}>Église</option>
                        <option value="company" {{ old('type') === 'company' ? 'selected' : '' }}>Entreprise</option>
                        <option value="association" {{ old('type') === 'association' ? 'selected' : '' }}>Association</option>
                        <option value="individual" {{ old('type') === 'individual' ? 'selected' : '' }}>Individu</option>
                        <option value="other" {{ old('type') === 'other' ? 'selected' : '' }}>Autre</option>
                    </select>
                    @if ($errors->has('type'))
                        <div class="error-message">{{ $errors->first('type') }}</div>
                    @endif
                    <div class="helper-text">Optionnel</div>
                </div>

                <div class="form-group">
                    <label for="website_url">
                        Site web
                    </label>
                    <input
                        type="url"
                        id="website_url"
                        name="website_url"
                        value="{{ old('website_url') }}"
                        placeholder="https://example.com"
                        class="{{ $errors->has('website_url') ? 'field-error' : '' }}"
                    >
                    @if ($errors->has('website_url'))
                        <div class="error-message">{{ $errors->first('website_url') }}</div>
                    @endif
                    <div class="helper-text">Optionnel</div>
                </div>
            </div>

            <div class="form-group">
                <label for="message">
                    Message
                </label>
                <textarea
                    id="message"
                    name="message"
                    placeholder="Décrivez votre demande et comment vous envisagez de collaborer avec nous..."
                    class="{{ $errors->has('message') ? 'field-error' : '' }}"
                ></textarea>
                @if ($errors->has('message'))
                    <div class="error-message">{{ $errors->first('message') }}</div>
                @endif
                <div class="helper-text">Optionnel (max. 2000 caractères)</div>
            </div>

            <div class="button-group">
                <button type="submit" class="button primary">Soumettre la demande</button>
                <a href="{{ route('partners.index') }}" class="button secondary">Annuler</a>
            </div>
        </form>
    </section>
</main>
</body>
</html>
