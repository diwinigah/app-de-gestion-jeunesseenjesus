<?php

declare(strict_types=1);

namespace App\Filament\Resources\CampEditionResource\Pages;

use App\Filament\Resources\CampEditionResource;
use App\Models\CampEdition;
use App\Services\CampEditionService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateCampEdition extends CreateRecord
{
    protected static string $resource = CampEditionResource::class;

    /**
     * @param array<string, mixed> $data
     */
    protected function handleRecordCreation(array $data): Model
    {
        return app(CampEditionService::class)->createEdition($data);
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Edition creee';
    }

    protected function getRedirectUrl(): string
    {
        /** @var CampEdition $record */
        $record = $this->getRecord();

        return static::getResource()::getUrl('edit', ['record' => $record]);
    }
}
