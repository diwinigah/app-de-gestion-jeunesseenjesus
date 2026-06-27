@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe - Investisseur')

@push('styles')
<style>
    .inv-rp-container { width: min(100%, 500px); margin: 40px auto; }
    .inv-rp-box { background: #fff; border: 1px solid #dfe3ea; border-radius: 8px; padding: 24px; }
    .inv-rp-h1 { margin: 0 0 24px; font-size: 1.8rem; color: #333; }
    .inv-rp-group { margin-bottom: 16px; }
    .inv-rp-label { display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.9rem; color: #333; }
    .inv-rp-input { width: 100%; padding: 10px; border: 1px solid #dfe3ea; border-radius: 4px; font-size: 0.95rem; font-family: Arial, sans-serif; color: #333; }
    .inv-rp-input:focus { outline: none; border-color: #E8490F; box-shadow: 0 0 0 3px rgba(232, 73, 15, 0.1); }
    .inv-rp-error { color: #dc2626; font-size: 0.85rem; margin-top: 4px; }
    .inv-rp-group.error .inv-rp-input { border-color: #dc2626; }
    .inv-rp-btn { display: inline-flex; width: 100%; align-items: center; justify-content: center; min-height: 44px; background: #E8490F; color: #fff; border: none; border-radius: 6px; font-size: 0.95rem; font-weight: 700; cursor: pointer; margin-top: 12px; }
    .inv-rp-btn:hover { background: #C73D0A; }
    .inv-rp-link { text-align: center; margin-top: 16px; }
    .inv-rp-link a { color: #E8490F; text-decoration: none; font-weight: 600; }
    @media (max-width: 600px) { .inv-rp-container { margin: 20px auto; } .inv-rp-box { padding: 18px; } }
</style>
@endpush

@section('content')
<div class="inv-rp-container">
    <div class="inv-rp-box">
        <h1 class="inv-rp-h1">Réinitialiser le mot de passe</h1>

        @if ($errors->any())
            <div class="inv-rp-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('investor.password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="inv-rp-group @error('email') error @enderror">
                <label for="email" class="inv-rp-label">Email *</label>
                <input type="email" name="email" id="email" class="inv-rp-input" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="inv-rp-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="inv-rp-group @error('password') error @enderror">
                <label for="password" class="inv-rp-label">Nouveau mot de passe *</label>
                <div class="password-field-wrapper">
                    <input type="password"
                           name="password"
                           id="password"
                           class="inv-rp-input form-input"
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
                @error('password')
                    <div class="inv-rp-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="inv-rp-group @error('password_confirmation') error @enderror">
                <label for="password_confirmation" class="inv-rp-label">Confirmer le mot de passe *</label>
                <div class="password-field-wrapper">
                    <input type="password"
                           name="password_confirmation"
                           id="password_confirmation"
                           class="inv-rp-input form-input"
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
                @error('password_confirmation')
                    <div class="inv-rp-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="inv-rp-btn">Réinitialiser le mot de passe</button>
        </form>

        <div class="inv-rp-link">
            <a href="{{ route('investor.login') }}">Retour à la connexion</a>
        </div>
    </div>
</div>
@endsection
</body>
</html>
