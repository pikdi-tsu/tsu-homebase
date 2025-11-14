<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
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

                Section::make('Main Navigation')
                    ->description('Atur link menu utama di header.')
                    ->schema([
                        Repeater::make('main_navigation')
                        ->label('Menu Items')
                            ->schema([
                                TextInput::make('label') // <-- Teks yang tampil (e.g., "Home")
                                ->required(),
                                TextInput::make('url')   // <-- URL-nya (e.g., "/" atau "/about-us")
                                ->required(),
                            ])
                            ->defaultItems(0) // Mulai dari 0
                            ->addActionLabel('Add Menu Link')
                            ->columns(2) // Biar 'label' dan 'url' sampingan
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
