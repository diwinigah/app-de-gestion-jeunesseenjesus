@extends('layouts.app')

@section('title', 'Partenaires')

@push('styles')
<style>
    .part-idx-header { margin-bottom: 24px; }
    .part-idx-eyebrow { color: #E8490F; font-size: .82rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; }
    .part-idx-h1 { margin: 6px 0 10px; font-size: clamp(1.9rem, 5vw, 3rem); color: #333; }
    .part-idx-lead { max-width: 680px; color: #5d6678; }

    .part-idx-empty,
    .part-idx-card {
        background: #fff;
        border: 1px solid #f0e8e4;
        border-radius: 12px;
    }
    .part-idx-empty {
        padding: 22px;
    }

    .part-idx-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
    }
    @media (min-width: 600px) {
        .part-idx-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (min-width: 960px) {
        .part-idx-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (min-width: 1200px) {
        .part-idx-grid { grid-template-columns: repeat(4, 1fr); }
    }

    .part-idx-card {
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(15,23,42,0.07);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .part-idx-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(232,73,15,0.10);
    }

    .part-idx-logo-wrapper {
        width: 100%;
        height: 110px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f9f3f0;
        border-bottom: 1px solid #f0e8e4;
        padding: 16px;
        box-sizing: border-box;
    }
    .part-idx-logo {
        max-width: 100%;
        max-height: 78px;
        width: auto;
        height: auto;
        object-fit: contain;
        display: block;
    }
    .part-idx-initials {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #E8490F, #ff6b35);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.3rem;
        box-shadow: 0 4px 12px rgba(232,73,15,0.25);
    }

    .part-idx-content {
        padding: 14px 16px 16px;
    }
    .part-idx-name {
        font-weight: 800;
        font-size: 0.98rem;
        margin: 0 0 6px;
        color: #3D2B1F;
        line-height: 1.3;
    }
    .part-idx-type {
        display: inline-block;
        padding: 3px 8px;
        background: #fdf6f3;
        color: #E8490F;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        margin-bottom: 8px;
        border: 1px solid #fde8dc;
    }
    .part-idx-desc {
        color: #666;
        font-size: 0.88rem;
        line-height: 1.55;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .part-idx-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }
    .part-idx-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 36px;
        padding: 0 14px;
        border-radius: 20px;
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: opacity 0.2s, transform 0.15s;
    }
    .part-idx-btn.primary {
        background: #E8490F;
        color: #fff;
        box-shadow: 0 2px 8px rgba(232,73,15,0.25);
    }
    .part-idx-btn.secondary {
        border: 1.5px solid #E8490F;
        color: #E8490F;
        background: #fff;
    }
    .part-idx-btn:hover {
        opacity: 0.88;
        transform: translateY(-1px);
    }

    .part-idx-cta {
        text-align: center;
        margin-top: 2.5rem;
        padding: 2rem 1.5rem;
        background: #fdf6f3;
        border: 1px solid #f0e8e4;
        border-radius: 16px;
    }
    .part-idx-cta h2 {
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        color: #3D2B1F;
        font-weight: 800;
    }
    .part-idx-cta p {
        color: #666;
        margin-bottom: 1.25rem;
        font-size: 0.92rem;
    }
</style>
@endpush

@section('content')
<div class="part-idx-header">
    <div class="part-idx-eyebrow"> </div>
    <h1 class="part-idx-h1">Nos partenaires</h1>
    <p class="part-idx-lead">Découvrez les organisations et entreprises qui soutiennent nos initiatives et accompagnent notre mission.</p>
</div>

@if ($partners->isEmpty())
    <section class="part-idx-empty">
        <h2>Aucun partenaire publié</h2>
        <p>Revenez bientôt pour découvrir nos partenaires.</p>
    </section>
@else
    <section class="part-idx-grid">
        @foreach ($partners as $partner)
            <article class="part-idx-card animate-left">
                <div class="part-idx-logo-wrapper">
                    @if ($partner->logo_path)
                        <img src="{{ asset('storage/' . $partner->logo_path) }}" alt="{{ $partner->name }}" class="part-idx-logo">
                    @else
                        <div class="part-idx-initials">
                            {{ substr($partner->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="part-idx-content">
                    <h3 class="part-idx-name">{{ $partner->name }}</h3>
                    @if ($partner->type)
                        <div class="part-idx-type">{{ $partner->type->label() }}</div>
                    @endif
                    @if ($partner->description)
                        <p class="part-idx-desc">{{ $partner->description }}</p>
                    @endif
                    <div class="part-idx-actions">
                        @if ($partner->website_url)
                            <a href="{{ $partner->website_url }}" target="_blank" rel="noopener noreferrer" class="part-idx-btn secondary">
                                Visiter le site
                            </a>
                        @endif
                    </div>
                </div>
            </article>
        @endforeach
    </section>
@endif

<section class="part-idx-cta">
    <h2>Vous souhaitez devenir partenaire ?</h2>
    <p>Rejoignez notre réseau de partenaires et participez à notre mission auprès de la jeunesse.</p>
    <a href="{{ route('partners.request') }}" class="part-idx-btn primary">Demander à devenir partenaire</a>
</section>
@endsection
