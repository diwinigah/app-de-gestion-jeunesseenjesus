<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Services\RegistrationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RegistrationController extends Controller
{
    public function show(RegistrationService $registrationService): View
    {
        if (! $registrationService->isRegistrationOpen()) {
            return view('registration.closed');
        }

        return view('registration.show', [
            'edition' => $registrationService->getOpenEdition(),
            'sections' => $registrationService->getOpenEditionSections(),
        ]);
    }

    public function store(StoreRegistrationRequest $request, RegistrationService $registrationService): View|RedirectResponse
    {
        $edition = $registrationService->getOpenEdition();

        if ($edition === null) {
            return redirect()
                ->route('registration.show')
                ->with('status', 'Inscriptions fermees');
        }

        $registration = $registrationService->createRegistration($request->validated(), $edition);

        return view('registration.success', [
            'registration' => $registration->registration_number,
        ]);
    }
}
