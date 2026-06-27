@extends('layouts.app')

@section('title', 'Investir dans ' . $project->title)

@push('styles')
<style>
.gate-page {
    max-width: 780px;
    margin: 3rem auto;
    padding: 0 1rem 4rem;
}

.gate-project-header {
    text-align: center;
    margin-bottom: 2.5rem;
}
.gate-project-tag {
    display: inline-block;
    background: #fdf6f3;
    border: 1.5px solid #E8490F;
    color: #E8490F;
    padding: 0.3rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 0.75rem;
}
.gate-project-title {
    font-size: 1.6rem;
    font-weight: 900;
    color: #3D2B1F;
    margin-bottom: 0.5rem;
    font-family: 'Raleway', sans-serif;
}
.gate-project-summary {
    font-size: 0.95rem;
    color: #666;
    max-width: 560px;
    margin: 0 auto;
    line-height: 1.7;
}

.gate-value-block {
    background: linear-gradient(135deg, #3D2B1F, #6b3a25);
    border-radius: 16px;
    padding: 2rem 2.5rem;
    margin-bottom: 2.5rem;
    color: #fff;
}
.gate-value-title {
    font-size: 1rem;
    font-weight: 800;
    color: #f9c97c;
    margin-bottom: 1rem;
    font-family: 'Raleway', sans-serif;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.gate-value-title svg {
    width: 20px;
    height: 20px;
    flex-shrink: 0;
}
.gate-value-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
}
.gate-value-item {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    font-size: 0.88rem;
    color: rgba(255,255,255,0.9);
    line-height: 1.5;
}
.gate-value-item svg {
    width: 16px;
    height: 16px;
    color: #f9c97c;
    flex-shrink: 0;
    margin-top: 2px;
}

.gate-options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}
.gate-card {
    background: #fff;
    border: 2px solid #f0e8e4;
    border-radius: 16px;
    padding: 2rem 1.5rem;
    text-align: center;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.gate-card:hover {
    border-color: #E8490F;
    box-shadow: 0 8px 24px rgba(232,73,15,0.1);
}
.gate-card-icon {
    width: 52px;
    height: 52px;
    background: #fdf6f3;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
}
.gate-card-icon svg {
    width: 26px;
    height: 26px;
    color: #E8490F;
}
.gate-card h3 {
    font-size: 1rem;
    font-weight: 800;
    color: #3D2B1F;
    margin-bottom: 0.4rem;
    font-family: 'Raleway', sans-serif;
}
.gate-card p {
    font-size: 0.82rem;
    color: #888;
    line-height: 1.5;
    margin-bottom: 1.25rem;
}
.gate-btn-primary {
    display: block;
    width: 100%;
    padding: 0.75rem;
    background: linear-gradient(135deg, #E8490F, #ff6b35);
    color: #fff;
    font-weight: 700;
    font-size: 0.9rem;
    border-radius: 10px;
    text-decoration: none;
    transition: opacity 0.2s, transform 0.15s;
    font-family: 'Raleway', sans-serif;
    box-shadow: 0 4px 14px rgba(232,73,15,0.3);
}
.gate-btn-primary:hover {
    opacity: 0.92;
    transform: translateY(-1px);
    color: #fff;
}
.gate-btn-secondary {
    display: block;
    width: 100%;
    padding: 0.75rem;
    background: #fff;
    color: #3D2B1F;
    font-weight: 700;
    font-size: 0.9rem;
    border-radius: 10px;
    text-decoration: none;
    border: 2px solid #3D2B1F;
    transition: background 0.2s, color 0.2s;
    font-family: 'Raleway', sans-serif;
}
.gate-btn-secondary:hover {
    background: #3D2B1F;
    color: #fff;
}

.gate-note {
    text-align: center;
    font-size: 0.8rem;
    color: #aaa;
    margin-top: 1rem;
}
.gate-note a {
    color: #E8490F;
    text-decoration: none;
}
.gate-note a:hover { text-decoration: underline; }

@media (max-width: 600px) {
    .gate-options { grid-template-columns: 1fr; }
    .gate-value-list { grid-template-columns: 1fr; }
    .gate-value-block { padding: 1.5rem 1.25rem; }
    .gate-project-title { font-size: 1.3rem; }
}
</style>
@endpush

@section('content')
@php
    $investRedirect = route('projects.invest.form', ['project' => $project->slug]);
@endphp

<div class="gate-page">
    <div class="gate-project-header">
        <span class="gate-project-tag">Projet à financer</span>
        <h1 class="gate-project-title">{{ $project->title }}</h1>
        @if($project->summary)
            <p class="gate-project-summary">{{ $project->summary }}</p>
        @endif
    </div>

    <div class="gate-value-block">
        <div class="gate-value-title">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.745 3.745 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.745 3.745 0 0 1 3.296-1.043A3.745 3.745 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.745 3.745 0 0 1 3.296 1.043 3.745 3.745 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
            </svg>
            Pourquoi créer un compte investisseur ?
        </div>
        <ul class="gate-value-list">
            <li class="gate-value-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                Suivez vos investissements et leur statut en temps réel depuis votre tableau de bord
            </li>
            <li class="gate-value-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                Accédez à l'historique de toutes vos propositions d'investissement
            </li>
            <li class="gate-value-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                Soyez notifié des évolutions sur les projets que vous soutenez
            </li>
            <li class="gate-value-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                Investissez sur plusieurs projets avec un seul compte
            </li>
        </ul>
    </div>

    <div class="gate-options">
        <div class="gate-card">
            <div class="gate-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                </svg>
            </div>
            <h3>J'ai déjà un compte</h3>
            <p>Connectez-vous pour accéder au formulaire d'investissement et soumettre votre proposition.</p>
            <a href="{{ route('investor.login', ['redirect' => $investRedirect]) }}" class="gate-btn-primary">
                Se connecter
            </a>
        </div>

        <div class="gate-card">
            <div class="gate-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
            </div>
            <h3>Je n'ai pas encore de compte</h3>
            <p>Créez votre compte investisseur gratuitement en quelques minutes et commencez à investir.</p>
            <a href="{{ route('investor.register', ['redirect' => $investRedirect]) }}" class="gate-btn-secondary">
                Créer un compte
            </a>
        </div>
    </div>

    <p class="gate-note">
        <a href="{{ route('projects.show', ['project' => $project->slug]) }}">
            &larr; Retour au projet
        </a>
    </p>
</div>
@endsection

@push('scripts')
<script>
(function () {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    const header = document.querySelector('.gate-project-header');
    const valueBlock = document.querySelector('.gate-value-block');
    const cards = document.querySelectorAll('.gate-card');

    if (header) {
        header.style.opacity = '0';
        header.style.transform = 'translateY(-20px)';
        header.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        setTimeout(function () {
            header.style.opacity = '1';
            header.style.transform = 'translateY(0)';
        }, 100);
    }

    if (valueBlock) {
        valueBlock.style.opacity = '0';
        valueBlock.style.transform = 'translateY(20px)';
        valueBlock.style.transition = 'opacity 0.6s ease 0.2s, transform 0.6s ease 0.2s';
        setTimeout(function () {
            valueBlock.style.opacity = '1';
            valueBlock.style.transform = 'translateY(0)';
        }, 100);
    }

    cards.forEach(function (card, i) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease ' + (0.4 + i * 0.15) + 's, transform 0.5s ease ' + (0.4 + i * 0.15) + 's';
        setTimeout(function () {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100);
    });
})();
</script>
@endpush
