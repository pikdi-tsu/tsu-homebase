<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use App\Filament\Resources\Pages\Schemas\PageForm;
use App\Models\Page;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getFormSchema(): array
    {
        // Panggil skema dari file tadi
        return PageForm::getSchema();
    }

    // Tambahkan ini untuk layout kolom
    protected function getFormModel(): string
    {
        return Page::class;
    }

    protected function getFormColumns(): int
    {
        return 3; // <-- Terapkan 3 kolom di sini
    }
}
