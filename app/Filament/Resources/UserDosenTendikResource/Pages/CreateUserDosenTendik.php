<?php

namespace App\Filament\Resources\UserDosenTendikResource\Pages;

use App\Filament\Resources\UserDosenTendikResource;
use App\Models\BackupUsersDosenTendik;
use App\Models\PertanyaanKeamanan;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class CreateUserDosenTendik extends CreateRecord
{
    protected static string $resource = UserDosenTendikResource::class;

    public static function getCreateFormSchema(): array
    {
        return [
            Grid::make()
                ->columns(2) // Buat 2 kolom
                ->schema([
                    Select::make('nik')
                        ->label('Name')
                        ->options(BackupUsersDosenTendik::all()->pluck('nama_lengkap_dan_nip', 'nip'))
                        ->required()
                        ->searchable()
                        ->preload()
                        ->live(debounce: 250)
                        ->afterStateUpdated(function ($state, callable $set) {
                            $user = BackupUsersDosenTendik::where('nip', $state)->first();
                            if ($user) {
                                $set('email', $user->email_kampus);
                                // $set('field_lain', $user->kolom_lain); // Tambahkan field lain jika ada
                            }
                        }),
                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->readonly(),
                    Select::make('q1')
                        ->label('Pertanyaan Keamanan 1')
                        ->options(
                            PertanyaanKeamanan::where('jenis', 'q1')->get() // 1. Ambil semua data sebagai collection
                            ->mapWithKeys(function ($item) { // 2. Lakukan iterasi untuk setiap item
                                // 3. Buat array [id => "Pertanyaan... ?"]
                                return [$item->id => $item->pertanyaan . '?'];
                            })
                        )
                        ->searchable()
                        ->required(),
                    Select::make('q2') // Ini akan menyimpan ID pertanyaan
                        ->label('Pertanyaan Keamanan 2')
                        ->options(
                            PertanyaanKeamanan::where('jenis', 'q2')->get() // 1. Ambil semua data sebagai collection
                            ->mapWithKeys(function ($item) { // 2. Lakukan iterasi untuk setiap item
                                // 3. Buat array [id => "Pertanyaan... ?"]
                                return [$item->id => $item->pertanyaan . '?'];
                            })
                        )
                        ->searchable()
                        ->required(),
                    TextInput::make('a1') // <-- Jangan lupa field untuk jawabannya
                    ->label('Jawaban Keamanan 1')
                        ->required(),
                    TextInput::make('a2') // <-- Jangan lupa field untuk jawabannya
                    ->label('Jawaban Keamanan 2')
                        ->required(),
//                    Forms\Components\DateTimePicker::make('email_verified_at'),
//                    Forms\Components\TextInput::make('password')
//                        ->password()
//                        ->required()
//                        ->maxLength(255)
//                        ->disabled(),
//                    Forms\Components\select::make('password_confirmation')
//                    Forms\Components\TextInput::make('current_team_id')
//                        ->numeric(),
//                    Forms\Components\TextInput::make('profile_photo_path')
//                        ->maxLength(2048),
//                    Forms\Components\Textarea::make('two_factor_secret')
//                        ->columnSpanFull(),
//                    Forms\Components\Textarea::make('two_factor_recovery_codes')
//                        ->columnSpanFull(),
//                    Forms\Components\DateTimePicker::make('two_factor_confirmed_at'),
            ])
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                static::getCreateFormSchema()
            ]);
    }
}
