<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\CampEditionStatus;
use App\Enums\PaymentStatus;
use App\Enums\RegistrationStatus;
use App\Models\CampEdition;
use App\Models\EditionSection;
use App\Models\Registration;
use App\Models\User;
use App\Notifications\NewRegistrationNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class RegistrationService
{
    public function __construct(
        private readonly CampEditionService $campEditionService,
    ) {}

    public function generateRegistrationNumber(CampEdition $edition): string
    {
        $nextNumber = Registration::query()
            ->where('camp_edition_id', $edition->getKey())
            ->count() + 1;

        return sprintf('CAMP-%d-%05d', $edition->year, $nextNumber);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function createRegistration(array $data, CampEdition $edition): Registration
    {
        return DB::transaction(function () use ($data, $edition): Registration {
            /** @var CampEdition $lockedEdition */
            $lockedEdition = CampEdition::query()
                ->whereKey($edition->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            /** @var EditionSection|null $section */
            $section = null;
            if (! empty($data['edition_section_id'])) {
                $section = EditionSection::query()
                    ->where('camp_edition_id', $lockedEdition->getKey())
                    ->where('id', (int) $data['edition_section_id'])
                    ->where('is_active', true)
                    ->first();
            }

            /** @var Registration $registration */
            $registration = Registration::query()->create([
                'camp_edition_id' => $lockedEdition->getKey(),
                'edition_section_id' => $data['edition_section_id'] ?? null,
                'registration_number' => $this->generateRegistrationNumber($lockedEdition),
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'gender' => $data['gender'],
                'phone' => $data['phone'],
                'whatsapp_phone' => $data['whatsapp_phone'] ?? null,
                'city' => $data['city'] ?? null,
                'days_presence' => $data['days_presence'] ?? null,
                'children_count' => isset($data['children_count']) ? (int) $data['children_count'] : null,
                'bus_departure' => isset($data['bus_departure']) ? (bool) $data['bus_departure'] : null,
                'total_amount' => $section ? $section->price : 0,
                'paid_amount' => 0,
                'remaining_amount' => $section ? $section->price : 0,
                'payment_status' => PaymentStatus::Unpaid,
                'registration_status' => RegistrationStatus::Pending,
                'submitted_at' => now(),
            ]);

            Notification::send(
                User::query()->get(),
                new NewRegistrationNotification($registration),
            );

            return $registration->load(['campEdition', 'editionSection']);
        });
    }

    public function isRegistrationOpen(): bool
    {
        return $this->getOpenEdition() !== null;
    }

    public function getOpenEdition(): ?CampEdition
    {
        $edition = $this->campEditionService->getCurrentActiveEdition();

        if ($edition === null) {
            return null;
        }

        if ($edition->status !== CampEditionStatus::Open) {
            return null;
        }

        if (now()->lt($edition->registration_open_at) || now()->gt($edition->registration_close_at)) {
            return null;
        }

        return $edition;
    }

    /**
     * @return Collection<int, EditionSection>
     */
    public function getOpenEditionSections(): Collection
    {
        $edition = $this->getOpenEdition();

        if ($edition === null) {
            return new Collection();
        }

        return $edition->editionSections()
            ->active()
            ->orderBy('section')
            ->get();
    }

    public function confirmRegistration(Registration $registration): void
    {
        $registration->update([
            'registration_status' => RegistrationStatus::Confirmed,
            'confirmed_at' => now(),
        ]);
    }

    public function cancelRegistration(Registration $registration): void
    {
        $registration->update([
            'registration_status' => RegistrationStatus::Cancelled,
            'confirmed_at' => null,
        ]);
    }
}
