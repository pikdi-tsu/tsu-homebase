<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserDosenTendikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserDosenTendik extends EditRecord
{
    protected static string $resource = UserDosenTendikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
