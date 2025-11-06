<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageGeneralSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string $settings = GeneralSettings::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('site_name')
                    ->columnSpanFull()
                    ->required(),
                FileUpload::make('site_logo')
                    ->label('Site Logo')
                    ->image()
                    ->disk('public')
                    ->columnSpanFull(),
                TextInput::make('footer_copyright')
                    ->label('Footer Copyright')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }
}
