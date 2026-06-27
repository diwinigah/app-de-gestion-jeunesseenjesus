@extends('layouts.app')

@section('title', "S'inscrire - Investisseur")

@push('styles')
<style>
    .inv-reg-container { width: min(100%, 500px); margin: 40px auto; }
    .inv-reg-form-box { background: #fff; border: 1px solid #dfe3ea; border-radius: 8px; padding: 24px; }
    .inv-reg-h1 { margin: 0 0 24px; font-size: 1.8rem; color: #333; }
    .inv-reg-group { margin-bottom: 16px; }
    .inv-reg-label { display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.9rem; color: #333; }
    .inv-reg-input, .inv-reg-textarea { width: 100%; padding: 10px; border: 1px solid #dfe3ea; border-radius: 4px; font-size: 0.95rem; font-family: Arial, sans-serif; color: #333; }
    .inv-reg-input:focus, .inv-reg-textarea:focus { outline: none; border-color: #E8490F; box-shadow: 0 0 0 3px rgba(232, 73, 15, 0.1); }
    .inv-reg-error-msg { color: #dc2626; font-size: 0.85rem; margin-top: 4px; }
    .inv-reg-group.error .inv-reg-input { border-color: #dc2626; }
    .inv-reg-btn { display: inline-flex; width: 100%; align-items: center; justify-content: center; min-height: 44px; background: #E8490F; color: #fff; border: none; border-radius: 6px; font-size: 0.95rem; font-weight: 700; cursor: pointer; margin-top: 12px; }
    .inv-reg-btn:hover { background: #C73D0A; }
    .inv-reg-btn:disabled { background: #ccc; cursor: not-allowed; }
    .inv-reg-link { text-align: center; margin-top: 16px; }
    .inv-reg-link a { color: #E8490F; text-decoration: none; font-weight: 600; }
    .inv-reg-link a:hover { text-decoration: underline; }
</style>
@endpush

@section('content')
<div class="inv-reg-container">
    <div class="inv-reg-form-box">
        <h1 class="inv-reg-h1">S'inscrire</h1>

        <form method="POST" action="{{ route('investor.register') }}">
            @csrf

            <div class="inv-reg-group @if ($errors->has('name') && session('_old_input')) error @endif">
                <label for="name" class="inv-reg-label">Nom complet *</label>
                <input type="text" name="name" id="name" class="inv-reg-input" value="{{ old('name') }}" required>
                @if ($errors->has('name') && session('_old_input'))
                    <div class="inv-reg-error-msg">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="inv-reg-group @if ($errors->has('organization_name') && session('_old_input')) error @endif">
                <label for="organization_name" class="inv-reg-label">Organisation</label>
                <input type="text" name="organization_name" id="organization_name" class="inv-reg-input" value="{{ old('organization_name') }}">
                @if ($errors->has('organization_name') && session('_old_input'))
                    <div class="inv-reg-error-msg">{{ $errors->first('organization_name') }}</div>
                @endif
            </div>

            <div class="inv-reg-group @if ($errors->has('email') && session('_old_input')) error @endif">
                <label for="email" class="inv-reg-label">Email *</label>
                <input type="email" name="email" id="email" class="inv-reg-input" value="{{ old('email') }}" required>
                @if ($errors->has('email') && session('_old_input'))
                    <div class="inv-reg-error-msg">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <div class="inv-reg-group @if ($errors->has('phone') && session('_old_input')) error @endif">
                <label for="phone" class="inv-reg-label">Téléphone *</label>
                <input type="tel" name="phone" id="phone" class="inv-reg-input" value="{{ old('phone') }}" placeholder="+226 XX XX XX XX" required>
                @if ($errors->has('phone') && session('_old_input'))
                    <div class="inv-reg-error-msg">{{ $errors->first('phone') }}</div>
                @endif
            </div>

            <div class="inv-reg-group @if ($errors->has('password') && session('_old_input')) error @endif">
                <label for="password" class="inv-reg-label">Mot de passe *</label>
                <div class="password-field-wrapper">
                    <input type="password"
                           name="password"
                           id="password"
                           class="inv-reg-input form-input"
                           required
                           autocomplete="new-password">
                    <button type="button"
                            class="password-toggle"
                            onclick="togglePassword('password')"
                            aria-label="Afficher/masquer le mot de passe">
                        <svg class="eye-icon eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <svg class="eye-icon eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display:none;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
                @if ($errors->has('password') && session('_old_input'))
                    <div class="inv-reg-error-msg">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <div class="inv-reg-group @if ($errors->has('password_confirmation') && session('_old_input')) error @endif">
                <label for="password_confirmation" class="inv-reg-label">Confirmer le mot de passe *</label>
                <div class="password-field-wrapper">
                    <input type="password"
                           name="password_confirmation"
                           id="password_confirmation"
                           class="inv-reg-input form-input"
                           required
                           autocomplete="new-password">
                    <button type="button"
                            class="password-toggle"
                            onclick="togglePassword('password_confirmation')"
                            aria-label="Afficher/masquer le mot de passe">
                        <svg class="eye-icon eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <svg class="eye-icon eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display:none;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
                @if ($errors->has('password_confirmation') && session('_old_input'))
                    <div class="inv-reg-error-msg">{{ $errors->first('password_confirmation') }}</div>
                @endif
            </div>

            <button
                type="submit"
                id="submit-btn"
                class="inv-reg-btn"
                onclick="this.disabled=true;
                         this.innerText='Envoi en cours...';
                         this.form.submit();">
                S'inscrire
            </button>
        </form>

        <div class="inv-reg-link">
            Vous avez déjà un compte ? <a href="{{ route('investor.login') }}">Se connecter</a>
        </div>
    </div>
</div>
@endsection
