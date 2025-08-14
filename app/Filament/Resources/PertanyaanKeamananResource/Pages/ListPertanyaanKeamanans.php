<?php

namespace App\Filament\Resources\PertanyaanKeamananResource\Pages;

use App\Filament\Resources\PertanyaanKeamananResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListPertanyaanKeamanans extends ListRecords
{
    protected static string $resource = PertanyaanKeamananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Pertanyaan Keamanan')
                ->modalHeading('Tambah User Dosen/Tendik')
                ->modalSubmitActionLabel('Simpan')
                ->modalCancelActionLabel('Batal'),
        ];
    }
}
