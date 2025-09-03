<?php

namespace App\Filament\Resources\OauthClients\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class OauthClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Modul/Aplikasi')
                    ->required()
                    ->columnSpanFull(),
                Select::make('owner_type')
                    ->label('Tipe Pemilik (Owner)')
                    ->options([
                        'App\\Models\\UserDosenTendik' => 'User Dosen/Tendik',
                        'App\\Models\\Mahasiswa' => 'Mahasiswa',
                    ])
                    // Hanya muncul jika kondisi terpenuhi
                    ->visible(fn ($get) => in_array('personal_access', $get('grant_types') ?? []))
                    ->required(),
                TextInput::make('owner_id')
                    ->label('ID Pemilik (Owner)')
                    // Hanya muncul jika kondisi terpenuhi
                    ->visible(fn ($get) => in_array('personal_access', $get('grant_types') ?? []))
                    ->required(),
                Select::make('grant_types')
                    ->label('Tipe Akses yang Diizinkan')
                    ->placeholder('Pilih Satu atau Lebih Tipe Akses')
                    ->multiple()
                    ->searchable()
                    ->options([
                        'client_credentials' => 'Client Credentials',
                        'authorization_code' => 'Authorization Code',
                        'password' => 'Password Grant',
                    ])
                    ->required()
                    ->live(),
                TagsInput::make('redirect_uris')
                    ->label('URL Redirect')
                    ->placeholder('Masukkan URL lalu tekan Enter')
                    ->required(),
                Placeholder::make('grant_type_descriptions')
                    ->label('Deskripsi Tipe Akses:')
                    ->content(new HtmlString(
                        '<ul class="list-disc list-inside text-sm text-gray-500 dark:text-gray-400">
                            <li><strong>Client Credentials:</strong> Paling umum untuk komunikasi antar server.</li>
                            <li><strong>Authorization Code:</strong> Untuk aplikasi web pihak ketiga (alur "Login dengan Google").</li>
                            <li><strong>Password Grant:</strong> Hanya untuk aplikasi pihak pertama yang sangat dipercaya.</li>
                            <li><strong>Personal Access:</strong> Untuk mengizinkan user membuat token pribadinya sendiri.</li>
                            <li><strong>Refresh Token:</strong> Izinkan klien untuk memperbarui access token.</li>
                        </ul>'
                    ))
                    ->columnSpanFull(),
            ]);
    }
}
