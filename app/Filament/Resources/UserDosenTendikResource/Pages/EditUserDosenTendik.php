<?php

namespace App\Filament\Resources\UserDosenTendikResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\UserDosenTendikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserDosenTendik extends EditRecord
{
    protected static string $resource = UserDosenTendikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
