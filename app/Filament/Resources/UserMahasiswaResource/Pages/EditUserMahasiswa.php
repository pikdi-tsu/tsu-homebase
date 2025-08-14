<?php

namespace App\Filament\Resources\UserMahasiswaResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\UserMahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserMahasiswa extends EditRecord
{
    protected static string $resource = UserMahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
