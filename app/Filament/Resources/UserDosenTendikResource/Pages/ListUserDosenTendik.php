<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserDosenTendikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserDosenTendik extends ListRecords
{
    protected static string $resource = UserDosenTendikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah User Dosen/Tendik')
                ->modalHeading('Tambah User Dosen/Tendik'),
        ];
    }
}
