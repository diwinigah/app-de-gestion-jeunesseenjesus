<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CampEditionService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use App\Models\Registration;
use App\Enums\RegistrationStatus;
use Illuminate\Http\RedirectResponse;

class PublicRegistrationListController extends Controller
{
    public function __construct(
        private readonly CampEditionService $campEditionService,
    ) {}

    public function index(): View|RedirectResponse
    {
        $activeEdition = $this->campEditionService->getCurrentActiveEdition();

        if ($activeEdition === null) {
            return view('public.inscriptions', [
                'registrations' => collect(),
                'edition' => null,
            ]);
        }

        /** @var LengthAwarePaginator<Registration> $registrations */
        $registrations = Registration::query()
            ->select([
                'id',
                'registration_number',
                'first_name',
                'last_name',
                'city',
                'payment_status',
                'registration_status',
                'edition_section_id',
                'submitted_at',
            ])
            ->where('camp_edition_id', $activeEdition->getKey())
            ->where('registration_status', RegistrationStatus::Confirmed)
            ->with(['campEdition', 'editionSection'])
            ->orderBy('last_name')
            ->paginate(50);

        return view('public.inscriptions', [
            'registrations' => $registrations,
            'edition' => $activeEdition,
        ]);
    }
}
