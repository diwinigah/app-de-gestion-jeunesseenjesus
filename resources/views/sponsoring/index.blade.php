@extends('layouts.app')

@section('title', 'Sponsoring ' . ($edition?->name ?? 'Camp'))

@push('styles')
<style>
.sponsoring-page { max-width: 960px; margin: 0 auto; padding: 1.5rem 1rem 3rem; }

/* HERO */
.sponsor-hero { border-radius: 16px; overflow: hidden; background: #3D2B1F; color: #fff; margin-bottom: 2.5rem; }
.sponsor-hero-img img { width: 100%; max-height: 220px; object-fit: cover; display: block; }
.sponsor-hero-content { padding: 2rem; text-align: center; }
.sponsor-tag { background: #E8490F; color: #fff; padding: 0.25rem 0.9rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; }
.sponsor-hero-content h1 { font-size: 1.8rem; font-weight: 800; margin: 0.75rem 0 0.25rem; }
.sponsor-theme { font-size: 1.2rem; color: #f9c97c; font-style: italic; margin: 0.25rem 0; }
.sponsor-verse { font-size: 0.9rem; opacity: 0.8; margin: 0.25rem 0; }
.ponsor-dates { font-size: 0.95rem; margin-top: 0.5rem; opacity: 0.9; }

/* SECTIONS */
.sponsor-section { margin-bottom: 2.5rem; }
.sponsor-intro { font-size: 1rem; line-height: 1.8; color: #444; background: #fdf6f3; border-left: 4px solid #E8490F; padding: 1.25rem 1.5rem; border-radius: 0 12px 12px 0; }
.section-title { font-size: 1.1rem; font-weight: 700; color: #3D2B1F; margin-bottom: 1rem; }

/* PROGRESSION */
.progress-cards { display: flex; flex-direction: column; gap: 1rem; }
.progress-card { background: #fff; border: 1px solid #f0e8e4; border-radius: 12px; padding: 1.25rem; }
.progress-label { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.6rem; font-size: 0.9rem; color: #555; }
.progress-label strong { color: #3D2B1F; font-size: 0.95rem; }
.progress-bar-track { background: #f0e8e4; border-radius: 99px; height: 12px; overflow: hidden; }
.progress-bar-fill { background: #E8490F; height: 100%; border-radius: 99px; transition: width 0.6s ease; }
.progress-bar-green { background: #22c55e; }
.progress-pct { font-size: 0.85rem; color: #888; margin-top: 0.35rem; display: block; text-align: right; }

/* BOURSES */
.bourse-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem; }
.bourse-card { background: #fff; border: 2px solid #f0e8e4; border-radius: 14px; padding: 1.25rem; text-align: center; }
.bourse-featured { border-color: #E8490F; background: #fff8f6; }
.bourse-libre { border-color: #f9c97c; background: #fffdf5; }
.bourse-icon { font-size: 1.8rem; margin-bottom: 0.5rem; }
.bourse-card h4 { font-size: 0.95rem; font-weight: 700; color: #3D2B1F; margin-bottom: 0.4rem; }
.bourse-card p { font-size: 0.8rem; color: #777; margin-bottom: 0.5rem; }
.bourse-amount { font-size: 1.4rem; font-weight: 800; color: #E8490F; }
.bourse-amount span { font-size: 0.75rem; font-weight: 600; }
.bourse-label { font-size: 0.75rem; color: #aaa; }

/* NATURE */
.nature-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 0.75rem; }
.nature-card { display: flex; align-items: flex-start; gap: 0.75rem; background: #fdf6f3; border-radius: 10px; padding: 0.9rem 1rem; }
.nature-num { background: #E8490F; color: #fff; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; flex-shrink: 0; }
.nature-card p { font-size: 0.88rem; color: #444; margin: 0; line-height: 1.5; }

/* PAIEMENT */
.payment-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; }
.payment-card { background: #fff; border: 1px solid #f0e8e4; border-radius: 12px; padding: 1.25rem; text-align: center; }
.payment-icon { font-size: 1.8rem; margin-bottom: 0.5rem; }
.payment-card h4 { font-weight: 700; color: #3D2B1F; margin-bottom: 0.4rem; font-size: 0.95rem; }
.payment-card p { font-size: 0.85rem; color: #555; margin: 0.2rem 0; }
.payment-link { display: inline-block; margin-top: 0.5rem; background: #E8490F; color: #fff; padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; text-decoration: none; }
.payment-link:hover { background: #c73d0d; }

/* CONTACT */
.sponsor-contact { text-align: center; }
.contact-info { display: flex; flex-wrap: wrap; justify-content: center; gap: 1.5rem; font-size: 1rem; color: #3D2B1F; font-weight: 600; }

/* CLOSED */
.sponsoring-closed { text-align: center; padding: 4rem 1rem; color: #888; }
.sponsoring-closed h1 { color: #3D2B1F; margin-bottom: 1rem; }

/* RESPONSIVE */
@media (max-width: 640px) {
    .sponsor-hero-content h1 { font-size: 1.3rem; }
    .bourse-grid { grid-template-columns: repeat(2, 1fr); }
    .payment-grid { grid-template-columns: 1fr 1fr; }
    .progress-label { flex-direction: column; align-items: flex-start; gap: 0.2rem; }
}

</style>
@endpush

@section('content')

@if(!$edition)
    <div class="sponsoring-closed">
        <h1>Page de sponsoring</h1>
        <p>Aucune campagne de sponsoring active pour le moment.</p>
        <p>Revenez bientôt !</p>
    </div>

@else

    {{-- HERO --}}
    <div class="sponsor-hero">
        @if($edition->cover_image_path)
            <div class="sponsor-hero-img">
                <img src="{{ Storage::url($edition->cover_image_path) }}" alt="{{ $edition->name }}">
            </div>
        @endif
        <div class="sponsor-hero-content">
            <div class="sponsor-tag">Sponsoring</div>
            <h1>{{ $edition->name }}</h1>
            @if($edition->sponsoring_theme)
                <div class="sponsor-theme">« {{ $edition->sponsoring_theme }} »</div>
            @endif
            @if($edition->sponsoring_verse)
                <div class="sponsor-verse">{{ $edition->sponsoring_verse }}</div>
            @endif
            @if($edition->camp_start_date && $edition->camp_end_date)
                <div class="sponsor-dates">📅 {{ \Carbon\Carbon::parse($edition->camp_start_date)->translatedFormat('d F') }} au {{ \Carbon\Carbon::parse($edition->camp_end_date)->translatedFormat('d F Y') }}</div>
            @endif
        </div>
    </div>

    {{-- INTRO --}}
    @if($edition->sponsoring_intro)
    <div class="sponsor-section sponsor-intro">{!! nl2br(e($edition->sponsoring_intro)) !!}</div>
    @endif

    {{-- PROGRESSION --}}
    @if(($edition->budget_total ?? 0) > 0)
    @php
        $budgetPct = $edition->budget_total > 0 ? min(100, round(($edition->budget_collected / $edition->budget_total) * 100)) : 0;
        $participantsPct = ($edition->participants_target ?? 0) > 0 ? min(100, round(($edition->participants_sponsored / $edition->participants_target) * 100)) : 0;
    @endphp
    <div class="sponsor-section">
        <div class="section-title">📊 Progression du sponsoring</div>
        <div class="progress-cards">
            <div class="progress-card">
                <div class="progress-label">
                    <div>Budget collecté <strong>{{ number_format($edition->budget_collected ?? 0, 0, ',', ' ') }} / {{ number_format($edition->budget_total ?? 0, 0, ',', ' ') }} FCFA</strong></div>
                </div>
                <div class="progress-bar-track"><div class="progress-bar-fill" style="width: {{ $budgetPct }}%;"></div></div>
                <span class="progress-pct">{{ $budgetPct }}%</span>
            </div>

            @if(($edition->participants_target ?? 0) > 0)
            <div class="progress-card">
                <div class="progress-label">
                    <div>Participants sponsorisés <strong>{{ $edition->participants_sponsored ?? 0 }} / {{ $edition->participants_target ?? 0 }}</strong></div>
                </div>
                <div class="progress-bar-track"><div class="progress-bar-fill progress-bar-green" style="width: {{ $participantsPct }}%;"></div></div>
                <span class="progress-pct">{{ $participantsPct }}%</span>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- TYPES DE BOURSES --}}
    <div class="sponsor-section">
        <div class="section-title">🎓 Offrir une bourse</div>
        <div class="bourse-grid">
            <div class="bourse-card bourse-featured">
                <div class="bourse-icon">⭐</div>
                <h4>Bourse Pleine</h4>
                <p>Couvrez l'intégralité des frais d'un jeune</p>
                <div class="bourse-amount">{{ number_format($edition->bourse_pleine_amount ?? 0, 0, ',', ' ') }} FCFA</div>
                <div class="bourse-label">par campeur</div>
            </div>

            <div class="bourse-card">
                <div class="bourse-icon">🧑</div>
                <h4>Adulte</h4>
                <div class="bourse-amount">{{ number_format($edition->bourse_adulte_amount ?? 0, 0, ',', ' ') }} FCFA</div>
            </div>

            <div class="bourse-card">
                <div class="bourse-icon">🎓</div>
                <h4>Étudiant</h4>
                <div class="bourse-amount">{{ number_format($edition->bourse_etudiant_amount ?? 0, 0, ',', ' ') }} FCFA</div>
            </div>

            <div class="bourse-card">
                <div class="bourse-icon">📚</div>
                <h4>Lycée / Collège</h4>
                <div class="bourse-amount">{{ number_format($edition->bourse_lycee_amount ?? 0, 0, ',', ' ') }} FCFA</div>
            </div>

            <div class="bourse-card">
                <div class="bourse-icon">👧</div>
                <h4>Enfant</h4>
                <div class="bourse-amount">{{ number_format($edition->bourse_enfant_amount ?? 0, 0, ',', ' ') }} FCFA</div>
            </div>

            <div class="bourse-card bourse-libre">
                <div class="bourse-icon">💛</div>
                <h4>Bourse Partielle</h4>
                <p>Contribuez selon votre cœur pour couvrir une partie des frais</p>
                <div class="bourse-label">Libre</div>
            </div>
        </div>
    </div>

    {{-- APPORTS EN NATURE --}}
    @if($edition->nature_contributions && count($edition->nature_contributions) > 0)
    <div class="sponsor-section">
        <div class="section-title">📦 Apports en nature</div>
        <div class="nature-grid">
            @foreach($edition->nature_contributions as $index => $item)
                <div class="nature-card">
                    <div class="nature-num">{{ $index + 1 }}</div>
                    <p>{{ is_array($item) && isset($item['designation']) ? e($item['designation']) : e($item) }}</p>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- MOYENS DE PAIEMENT --}}
    <div class="sponsor-section">
        <div class="section-title">💳 Comment contribuer ?</div>
        <div class="payment-grid">
            @if($edition->payment_flooz)
            <div class="payment-card">
                <div class="payment-icon">📱</div>
                <h4>Flooz</h4>
                <p>{{ e($edition->payment_flooz) }}</p>
            </div>
            @endif

            @if($edition->payment_mixx)
            <div class="payment-card">
                <div class="payment-icon">📱</div>
                <h4>Mixx by YAS</h4>
                <p>{{ e($edition->payment_mixx) }}</p>
            </div>
            @endif

            @if($edition->payment_account_name || $edition->payment_account_number)
            <div class="payment-card">
                <div class="payment-icon">🏦</div>
                <h4>Virement bancaire</h4>
                @if($edition->payment_account_name)
                    <p><strong>Compte :</strong> {{ e($edition->payment_account_name) }}</p>
                @endif
                @if($edition->payment_account_number)
                    <p><strong>N° :</strong> {{ e($edition->payment_account_number) }}</p>
                @endif
                @if($edition->payment_iban)
                    <p><strong>IBAN :</strong> {{ e($edition->payment_iban) }}</p>
                @endif
            </div>
            @endif

            @if($edition->payment_paypal)
            <div class="payment-card">
                <div class="payment-icon">💻</div>
                <h4>PayPal</h4>
                <p><a class="payment-link" href="{{ e($edition->payment_paypal) }}" target="_blank" rel="noopener">Contribuer via PayPal →</a></p>
            </div>
            @endif
        </div>
    </div>

    {{-- CONTACT --}}
    @if($edition->sponsoring_contact_email || $edition->sponsoring_contact_phone)
    <div class="sponsor-section sponsor-contact">
        <div class="section-title">📞 Nous contacter</div>
        <div class="contact-info">
            @if($edition->sponsoring_contact_phone)
                {{-- Ne jamais afficher les numéros des inscrits — ici c'est le contact sponsoring administratif configuré. --}}
                <div>📞 {{ e($edition->sponsoring_contact_phone) }}</div>
            @endif
            @if($edition->sponsoring_contact_email)
                <div>✉️ <a href="mailto:{{ e($edition->sponsoring_contact_email) }}">{{ e($edition->sponsoring_contact_email) }}</a></div>
            @endif
        </div>
    </div>
    @endif

@endif

@endsection
