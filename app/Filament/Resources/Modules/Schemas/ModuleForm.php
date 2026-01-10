<?php

namespace App\Filament\Resources\Modules\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ModuleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Module')
                    ->maxLength(255)
                    ->required(),
                TextInput::make('url')
                    ->label('App URL Module')
                    ->placeholder('https://aplikasi.tsu.ac.id')
                    ->url()
                    ->required(),
            ]);
    }
}
