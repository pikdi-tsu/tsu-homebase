<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use App\Filament\Resources\UserDosenTendikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserDosenTendik extends ListRecords
{
    protected static string $resource = UserDosenTendikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah User Dosen/Tendik')
                ->modalHeading('Tambah User Dosen/Tendik')
                ->modalSubmitActionLabel('Simpan')
                ->modalCancelActionLabel('Batal')
                ->createAnotherAction(fn (Action $action) => $action->label('Simpan & Tambah Lagi')),
        ];
    }
}
