<?php

namespace App\Filament\Resources\UserMahasiswaResource\Pages;

use App\Filament\Resources\UserMahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserMahasiswa extends ListRecords
{
    protected static string $resource = UserMahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah User Mahasiswa')
                ->modalHeading('Tambah User Mahasiswa'),
        ];
    }
}
