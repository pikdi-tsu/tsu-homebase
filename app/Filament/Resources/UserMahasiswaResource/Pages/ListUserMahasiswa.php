<?php

namespace App\Filament\Resources\UserMahasiswaResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use App\Filament\Resources\UserMahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserMahasiswa extends ListRecords
{
    protected static string $resource = UserMahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah User Mahasiswa')
                ->modalHeading('Tambah User Mahasiswa')
                ->modalSubmitActionLabel('Simpan')
                ->modalCancelActionLabel('Batal')
                ->createAnotherAction(fn (Action $action) => $action->label('Simpan & Tambah Lagi')),
        ];
    }
}
