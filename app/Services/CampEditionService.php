<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\CampEditionStatus;
use App\Models\CampEdition;
use Illuminate\Support\Facades\DB;

class CampEditionService
{
    /**
     * @param array<string, mixed> $data
     */
    public function createEdition(array $data): CampEdition
    {
        return DB::transaction(function () use ($data): CampEdition {
            $shouldActivate = (bool) ($data['is_active'] ?? false);
            $data['is_active'] = false;

            /** @var CampEdition $edition */
            $edition = CampEdition::query()->create($data);

            if ($shouldActivate) {
                $this->activateEdition($edition);
            }

            return $edition->refresh();
        });
    }

    /**
     * @param array<string, mixed> $data
     */
    public function updateEdition(CampEdition $edition, array $data): CampEdition
    {
        return DB::transaction(function () use ($edition, $data): CampEdition {
            $shouldActivate = (bool) ($data['is_active'] ?? false);
            $data['is_active'] = false;

            $edition->update($data);

            if ($shouldActivate) {
                $this->activateEdition($edition);
            }

            return $edition->refresh();
        });
    }

    public function activateEdition(CampEdition $edition): void
    {
        DB::transaction(function () use ($edition): void {
            CampEdition::query()
                ->whereKeyNot($edition->getKey())
                ->update(['is_active' => false]);

            $edition->update(['is_active' => true]);
        });
    }

    public function archiveEdition(CampEdition $edition): void
    {
        DB::transaction(function () use ($edition): void {
            $edition->update([
                'status' => CampEditionStatus::Archived,
                'is_active' => false,
            ]);
        });
    }

    public function getCurrentActiveEdition(): ?CampEdition
    {
        return CampEdition::query()
            ->active()
            ->where('status', '!=', CampEditionStatus::Archived->value)
            ->first();
    }
}
