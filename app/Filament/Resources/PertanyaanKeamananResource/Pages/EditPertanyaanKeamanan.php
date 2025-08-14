<?php

namespace App\Filament\Resources\PertanyaanKeamananResource\Pages;

use App\Filament\Resources\PertanyaanKeamananResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPertanyaanKeamanan extends EditRecord
{
    protected static string $resource = PertanyaanKeamananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
