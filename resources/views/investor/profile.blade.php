@extends('layouts.app')

@section('title', 'Mon profil - Investisseur')

@push('styles')
<style>
    .inv-profile-container { width: min(100%, 600px); margin: 40px auto; }
    .inv-profile-back { display: inline-block; margin-bottom: 16px; color: #E8490F; text-decoration: none; font-weight: 600; }
    .inv-profile-back:hover { text-decoration: underline; }
    .inv-profile-box { background: #fff; border: 1px solid #dfe3ea; border-radius: 8px; padding: 24px; }
    .inv-profile-h1 { margin: 0 0 24px; font-size: 1.8rem; color: #333; }
    .inv-profile-group { margin-bottom: 16px; }
    .inv-profile-label { display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.9rem; color: #333; }
    .inv-profile-input { width: 100%; padding: 10px; border: 1px solid #dfe3ea; border-radius: 4px; font-size: 0.95rem; font-family: Arial, sans-serif; color: #333; }
    .inv-profile-input:focus { outline: none; border-color: #E8490F; box-shadow: 0 0 0 3px rgba(232, 73, 15, 0.1); }
    .inv-profile-error { color: #dc2626; font-size: 0.85rem; margin-top: 4px; }
    .inv-profile-group.error .inv-profile-input { border-color: #dc2626; }
    .inv-profile-success { background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; }
    .inv-profile-btn { display: inline-flex; width: 100%; align-items: center; justify-content: center; min-height: 44px; background: #E8490F; color: #fff; border: none; border-radius: 6px; font-size: 0.95rem; font-weight: 700; cursor: pointer; margin-top: 12px; }
    .inv-profile-btn:hover { background: #C73D0A; }
</style>
@endpush

@section('content')
<div class="inv-profile-container">
    <a href="{{ route('investor.dashboard') }}" class="inv-profile-back">Retour au tableau de bord</a>

    <div class="inv-profile-box">
        <h1 class="inv-profile-h1">Mon profil</h1>

        @if (session('success'))
            <div class="inv-profile-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('investor.profile.update') }}">
            @csrf

            <div class="inv-profile-group @error('name') error @enderror">
                <label for="name" class="inv-profile-label">Nom *</label>
                <input type="text" name="name" id="name" class="inv-profile-input" value="{{ old('name', $investor->name) }}" required>
                @error('name')
                    <div class="inv-profile-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="inv-profile-group @error('organization_name') error @enderror">
                <label for="organization_name" class="inv-profile-label">Organisation</label>
                <input type="text" name="organization_name" id="organization_name" class="inv-profile-input" value="{{ old('organization_name', $investor->organization_name) }}">
                @error('organization_name')
                    <div class="inv-profile-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="inv-profile-group @error('phone') error @enderror">
                <label for="phone" class="inv-profile-label">Telephone</label>
                <input type="text" name="phone" id="phone" class="inv-profile-input" value="{{ old('phone', $investor->phone) }}" required>
                @error('phone')
                    <div class="inv-profile-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="inv-profile-group @error('email') error @enderror">
                <label for="email" class="inv-profile-label">Email *</label>
                <input type="email" name="email" id="email" class="inv-profile-input" value="{{ old('email', $investor->email) }}" required>
                @error('email')
                    <div class="inv-profile-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="inv-profile-btn">Mettre a jour</button>
        </form>
    </div>
</div>
@endsection
