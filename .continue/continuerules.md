## Mode de fonctionnement
- Toujours utiliser le mode Agent
- Autoriser automatiquement les modifications de fichiers et l'exécution des commandes
- Après chaque changement, exécuter `php artisan test`
- Itérer jusqu'à ce que les tests passent


Tu es un développeur Laravel Senior.

# RÉSUMÉ DU PROJET — Plateforme Camp & Projets
## Jeunesse en Jésus

═══════════════════════════════════════════════════
IDENTITÉ DU PROJET
═══════════════════════════════════════════════════

**Nom complet** : Plateforme Camp & Projets — Jeunesse en Jésus
**Type** : Plateforme web de gestion & investissement
**Stack** : Laravel 12 + Filament v3 + MySQL
**Environnement** : Windows / XAMPP local
**Chemin projet** : C:/Users/Nathan/Desktop/appj2
**URL locale** : http://127.0.0.1:8000
**URL admin** : http://127.0.0.1:8000/admin

**Comptes accès** :
- Admin Filament : jeunesseenjesus2026@gmail.com / password
- Site officiel séparé : jeunesseenjesus.org (Sulu CMS — non modifiable)

═══════════════════════════════════════════════════
OBJECTIF MÉTIER
═══════════════════════════════════════════════════

Plateforme permettant :
1. Inscriptions au camp annuel (formulaire public, paiements)
2. Gestion multi-éditions par année
3. Propositions d'investissement dans les projets
4. Partenariats avec organisations
5. Back-office admin complet via Filament

Deux publics distincts :
- **Visiteurs publics** : inscription camp, consultation projets, demande partenariat
- **Investisseurs** : compte séparé, consultation projets, propositions investissement

═══════════════════════════════════════════════════
ARCHITECTURE DE SÉCURITÉ
═══════════════════════════════════════════════════

**Deux guards d'authentification isolés** :
- `web` → Admins Filament (table `users`)
- `investor` → Investisseurs (table `investor_users`)
- **Règle absolue** : Guards JAMAIS mélangés

**Password brokers séparés** :
- Broker `default` → table `password_reset_tokens` (admins)
- Broker `investors` → table `investor_password_reset_tokens` (investisseurs)

**Infrastructure asynchrone** :
- Queue connection : `database`
- SMTP : Gmail configuré dans `.env`
- Scheduler : `editions:close-expired` (horaire)
- Worker : doit tourner en permanence

═══════════════════════════════════════════════════
MODÈLE DE DONNÉES — 13 TABLES
═══════════════════════════════════════════════════

### 1. ADMINS & AUTHENTIFICATION

**users**
- Admins Filament uniquement
- Colonne unique : email

**investor_users**
- Investisseurs compte séparé
- Colonnes : name, organization_name, email, phone, password
- Guard : `investor`

**password_reset_tokens** | **investor_password_reset_tokens**
- Réinitialisation mot de passe (2 tables distinctes)

### 2. CAMP — ÉDITIONS & INSCRIPTIONS

**camp_editions**
- Éditions annuelles du camp
- Colonnes : name, slug, year, description, 
  registration_open_at, registration_close_at,
  camp_start_date, camp_end_date,
  status (CampEditionStatus enum), is_active

**edition_sections**
- Tarifs par section/édition
- Colonnes : camp_edition_id, section (SectionType enum),
  price, description, is_active

**registrations**
- Inscriptions camp (sans compte obligatoire)
- Colonnes : camp_edition_id, edition_section_id,
  registration_number (CAMP-{ANNÉE}-{00001}),
  first_name, last_name, gender, phone, whatsapp_phone, city,
  total_amount, paid_amount, remaining_amount,
  payment_status (PaymentStatus enum),
  registration_status (RegistrationStatus enum),
  notes, admin_notes, submitted_at

**registration_payments**
- Paiements manuels hors plateforme
- Colonnes : registration_id, amount, currency,
  payment_method (PaymentMethod enum), reference,
  paid_at, validated_by (user_id), notes

### 3. PROJETS & INVESTISSEMENTS

**projects**
- Projets à financer
- Colonnes : title, slug, summary, description,
  funding_goal, funded_amount, currency,
  status (ProjectStatus enum),
  featured_image_path, is_featured, published_at

**project_investor_interests**
- Propositions d'investissement
- Colonnes : project_id, investor_user_id (nullable),
  manual_name, manual_organisation, manual_email, manual_phone,
  intended_amount, committed_amount, currency,
  status (ProjectInvestorInterestStatus enum),
  message, admin_notes
- **Note** : Pas de contrainte unique (un investisseur = plusieurs investissements possibles)

### 4. PARTENAIRES

**partners**
- Partenaires publiés sur le site
- Colonnes : name, slug, type (PartnerType enum),
  description, logo_path, website_url, email, phone,
  is_public, display_order, status (PartnerStatus enum)

**partner_requests**
- Demandes de partenariat
- Colonnes : organization_name, contact_name, email, phone,
  type, website_url, message, logo_path,
  status (PartnerRequestStatus enum),
  converted_partner_id, submitted_at

### 5. AUDIT & NOTIFICATIONS

**notifications**
- Table native Laravel (channel base de données Filament)

**activity_logs**
- Journal d'audit admin (qui a fait quoi, quand)

═══════════════════════════════════════════════════
ÉNUMÉRATIONS (Enums avec label() & color())
═══════════════════════════════════════════════════

**CampEditionStatus** : Draft, Open, Closed, Archived (⚠️ PascalCase)
**RegistrationStatus** : pending, confirmed, cancelled
**PaymentStatus** : unpaid, partial, paid
**SectionType** : college, lycee, universitaire, adulte, invite, famille
**PaymentMethod** : cash, mobile_money, bank_transfer, cheque, other
**Gender** : male, female, other
**ProjectStatus** : draft, published, funded, archived
**ProjectInvestorInterestStatus** : new, contacted, pledged, paid, cancelled
**PartnerType** : church, company, association, individual, other
**PartnerStatus** : active, inactive, archived
**PartnerRequestStatus** : new, reviewed, accepted, rejected, archived
**InvestorStatus** : new, contacted, interested, committed, rejected, archived

═══════════════════════════════════════════════════
SERVICES MÉTIER (Logique applicative)
═══════════════════════════════════════════════════

**CampEditionService**
- createEdition, updateEdition
- activateEdition (désactive toutes les autres)
- archiveEdition
- getCurrentActiveEdition
- createWithSections

**RegistrationService**
- generateRegistrationNumber (CAMP-{ANNÉE}-{00001})
- createRegistration
- isRegistrationOpen
- confirmRegistration, cancelRegistration

**RegistrationPaymentService**
- addPayment (vérifie montant ≤ remaining_amount)
- recalculateAmounts (total, paid, remaining)
- deletePayment
- **Contrainte** : Tout en transaction DB
- **Performance** : saveQuietly() pour éviter boucles d'observers

**ProjectService**
- createProject, updateProject
- publishProject, archiveProject
- updateFundedAmount (**saveQuietly() obligatoire**)
- getProgressPercentage

**InvestorService**
- registerInvestor (validation, création compte)
- createInvestment + notification admin

**PartnerService**
- createPartnerRequest
- approveRequest, rejectRequest
- convertToPartner (copie logo_path)

═══════════════════════════════════════════════════
BACK-OFFICE FILAMENT (/admin)
═══════════════════════════════════════════════════

**CampEditionResource**
- Création : Wizard 2 étapes
  - Étape 1 : informations édition (name, year, dates, description)
  - Étape 2 : sections et tarifs (Repeater)
    - Toggle : copier sections édition précédente
    - Repeater : TextInput datalist + defaultItems(0)
- Blocage si édition active existe
- RelationManager : EditionSections
- getRedirectUrl() → liste après save

**RegistrationResource**
- Colonnes toggleables (téléphone masqué par défaut)
- Actions groupées en menu ⋮
- RelationManager : Payments
- Actions rapides : Confirmer paiement, Paiement partiel
- Export Excel (ExportAction Filament natif)
- getRedirectUrl() → liste après save

**ProjectResource**
- Upload image (disk: `public`, directory: `projects`)
- **⚠️ Requis** : APP_URL=http://127.0.0.1:8000 pour affichage
- RelationManager : InvestorInterests
- Actions : Publier, Archiver
- getRedirectUrl() → liste après save

**InvestorInterestResource**
- Toggle virtuel : `has_account` (non sauvegardé en DB)
- Si has_account=true : Select investor_user_id
- Si has_account=false : champs manuels (manual_name, etc.)
- Actions : Confirmer, Rejeter, Enregistrer paiement
- getRedirectUrl() → liste après save

**PartnerResource**
- Upload logo (disk: `public`, directory: `partners`)
- Actions : Activer, Désactiver, Archiver
- getRedirectUrl() → liste après save

**PartnerRequestResource**
- Upload logo (colonne logo_path)
- Tous les champs éditables par l'admin
- Action : Convertir en partenaire (visible si status=accepted)
- getRedirectUrl() → liste après save

**Dashboard Widgets**
- StatsOverviewWidget : 6 cartes édition active
- InscriptionsParSectionWidget : TableWidget
- DernieresInscriptionsWidget : TableWidget
- databaseNotifications() + polling 30s activé

═══════════════════════════════════════════════════
ROUTES PUBLIQUES (Non-Admin)
═══════════════════════════════════════════════════

**CAMP**
```
GET  /camp                    → formulaire inscription
POST /camp                    → soumettre inscription (throttle:10,1)
GET  /camp/confirmation       → page succès
GET  /inscrits                → liste publique inscriptions
```

**PROJETS**
```
GET  /projets                 → liste tous les projets
GET  /projets/{slug}          → détail projet
```

**INVESTISSEURS**
```
GET  /investisseur/inscription           → formulaire création compte
POST /investisseur/inscription           → soumettre
GET  /investisseur/connexion             → formulaire connexion
POST /investisseur/connexion             → valider
POST /investisseur/deconnexion           → logout
GET  /investisseur/tableau-de-bord       → dashboard (auth:investor)
GET  /projets/{slug}/investir            → détail pour investir
POST /projets/{slug}/investir            → soumettre proposition (auth:investor)
GET  /investisseur/mot-de-passe-oublie   → formulaire oubli
POST /investisseur/mot-de-passe-oublie   → envoyer email
GET  /investisseur/reinitialiser/{token} → formulaire reset
POST /investisseur/reinitialiser         → valider nouveau mdp
```

**PARTENAIRES**
```
GET  /partenaires                    → liste publique partenaires
GET  /partenaires/demande            → formulaire demande
POST /partenaires/demande            → soumettre (throttle:10,1)
GET  /partenaires/confirmation       → succès
```

═══════════════════════════════════════════════════
NOTIFICATIONS (Tous ShouldQueue)
═══════════════════════════════════════════════════

**NewRegistrationNotification**
- Déclencheur : inscription au camp
- Canaux : mail + database
- Destinataires : User::all()
- Format Filament : getDatabaseMessage()

**NewInvestmentNotification**
- Déclencheur : proposition investissement
- Canaux : mail + database
- Destinataires : User::all()

**NewPartnerRequestNotification**
- Déclencheur : demande partenariat
- Canaux : mail + database
- Destinataires : User::all()

**InvestorResetPasswordNotification**
- Déclencheur : réinitialisation mot de passe investisseur
- Canaux : mail
- Destinataire : investor_user

═══════════════════════════════════════════════════
IDENTITÉ VISUELLE
═══════════════════════════════════════════════════

**Couleurs**
- Orange principal : #E8490F
- Brun topbar : #3D2B1F
- Gris footer : #F9F3F0

**Composants**
- Favicon : `public/images/logo.png`
- Logo SVG : `public/images/logo.svg`
- Topbar : masquée sur mobile (display:none)
- Menu hamburger sur mobile

**Layout principal** : `resources/views/layouts/app.blade.php`
- Toutes les vues publiques : `@extends('layouts.app')`
- Composant investisseur : `resources/views/components/investor-navbar.blade.php`
  (utilisé uniquement sur vues authentifiées investisseur)

═══════════════════════════════════════════════════
VUES PUBLIQUES (Blade)
═══════════════════════════════════════════════════

**Inscriptions Camp**
- `registration/show.blade.php` → formulaire
- `registration/closed.blade.php` → inscription fermée
- `registration/success.blade.php` → confirmation
- `public/inscriptions.blade.php` → liste publique

**Projets**
- `projects/index.blade.php` → liste
- `projects/show.blade.php` → détail

**Investisseurs**
- `investor/register.blade.php` → création compte
- `investor/login.blade.php` → connexion
- `investor/dashboard.blade.php` → tableau de bord
- `investor/invest.blade.php` → formulaire proposition
- `investor/forgot-password.blade.php` → oubli mdp
- `investor/reset-password.blade.php` → réinitialisation

**Partenaires**
- `partners/index.blade.php` → liste publique
- `partners/request.blade.php` → formulaire demande
- `partners/confirmation.blade.php` → confirmation

═══════════════════════════════════════════════════
COMMANDES ARTISAN
═══════════════════════════════════════════════════

**php artisan editions:close-expired**
- Ferme automatiquement éditions expirées
- Utilise CampEditionStatus::Closed (⚠️ PascalCase)
- Utilise saveQuietly() pour éviter boucle d'observers
- Planifiée : hourly dans `routes/console.php`

**php artisan email:test --to=email@example.com**
- Teste configuration SMTP Gmail

═══════════════════════════════════════════════════
RÈGLES DE DÉVELOPPEMENT OBLIGATOIRES
═══════════════════════════════════════════════════

**ARCHITECTURE**
✓ Logique métier UNIQUEMENT dans Services
✓ Contrôleurs : délègation simple, zéro logique
✓ Filament pour back-office admin complet
✗ Jamais de logique dans les vues
✗ Jamais de logique dans les migrations

**BASE DE DONNÉES**
✓ Migrations propres et versionées
✓ saveQuietly() obligatoire sur updateFundedAmount
✓ Transactions DB sur opérations critiques
✓ Eager loading (éviter N+1 queries)
✓ $fillable sur tous les modèles
✗ $guarded INTERDIT

**SÉCURITÉ**
✓ Form Request Validation sur chaque formulaire
✓ CSRF sur chaque formulaire POST/PUT/DELETE
✓ Rate limiting sur POST publics (throttle:10,1)
✓ phone/whatsapp jamais dans vues publiques
✓ ShouldQueue sur toutes les notifications
✓ Guards séparés jamais mélangés

**FILAMENT v3**
✓ BadgeColumn → TextColumn avec ->badge()
✓ Actions groupées en menu ⋮ (sauf actions rapides)
✓ getRedirectUrl() sur chaque page Edit
✓ Tous les enums : label() + color()
✓ copyable() uniquement sur TextColumn (pas TextInput)

**PERFORMANCES**
✓ saveQuietly() partout où funded_amount change
✓ Queue worker tourne 24/7
✓ Redémarrer worker après modif .env
✓ Utiliser FacadesCache quand applicable

**INTERDICTIONS ABSOLUES**
✗ Supprimer du code sans justification écrite
✗ Modifier code non-concerné par la tâche
✗ Duplication de logique métier
✗ Mélanger guards web et investor
✗ Logique dans les observers sans justification
✗ UPDATE directs en base de données
✗ Créer des tables sans migrations

═══════════════════════════════════════════════════
PROTOCOLE AVANT CHAQUE MODIFICATION
═══════════════════════════════════════════════════

1. ✓ **Lire** les fichiers concernés avant de coder
2. ✓ **Lister** les fichiers créés ou modifiés
3. ✓ **Expliquer** les impacts de chaque changement
4. ✓ **Générer** le code complet (pas de pseudo-code)
5. ✓ **Tester** avec `php artisan test`
6. ✓ **Vérifier** que aucune régression

Ce protocole s'applique à **CHAQUE MODIFICATION** sans exception.

═══════════════════════════════════════════════════
ÉTAT DU PROJET
═══════════════════════════════════════════════════

**Statut** : En développement (v1.0)
**Stabilité** : Fonctionnel, optimisations en cours
**Prochaines versions** :
- V1.1 : Optimisations perfs, améliorations UX
- V2.0 : Nouvelles fonctionnalités méta-projets

**Documentation** :
- DATABASE_DESIGN.md → schéma complet
- SECURITY_AUDIT.md → audit de sécurité
- PERFORMANCE_TUNING.md → optimisations
- TEST_SUITE.md → couverture tests

═══════════════════════════════════════════════════
