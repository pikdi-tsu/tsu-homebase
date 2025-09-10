<?php

namespace App\Filament\Resources\UserMahasiswaResource\Pages;

use App\Filament\Resources\UserMahasiswaResource;
use App\Models\BackupUsersMahasiswa;
use App\Models\PertanyaanKeamanan;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class CreateUserMahasiswa extends CreateRecord
{
    protected static string $resource = UserMahasiswaResource::class;

    public static function getCreateFormSchema(): array
    {
        return [
            Grid::make()
                ->columns(2) // Buat 2 kolom
                ->schema([
                    Select::make('nim')
                        ->label('NIM - Nama Mahasiswa')
                        ->placeholder('Pilih salah satu data Mahasiswa')
//                        ->options(BackupUsersMahasiswa::all()->pluck('nama_lengkap_dan_nim', 'nim'))
                        ->searchPrompt('Ketik NIM atau Nama untuk mencari...')
                        ->getSearchResultsUsing(function (string $search): array {
                            if (strlen($search) < 3) {
                                return [];
                            }

                            return BackupUsersMahasiswa::where('nama', 'like', "%{$search}%")
                                ->orWhere('nim', 'like', "%{$search}%")
                                ->limit(50)
                                ->get()
                                ->pluck('nama_lengkap_dan_nim', 'nim')
                                ->all();
                        })
                        ->getOptionLabelUsing(function ($value): ?string {
                            return BackupUsersMahasiswa::where('nim', $value)->first()?->nama_lengkap_dan_nim;
                        })
                        ->afterStateUpdated(function ($state, callable $set) {
                            if (is_null($state)) {
                                $set('email', null);
                                return;
                            }

                            $user = BackupUsersMahasiswa::where('nim', $state)->first();
                            if ($user) {
                                $set('email', $user->email);
                                // $set('field_lain', $user->kolom_lain); // Tambahkan field lain jika ada
                            } else {
                                $set('email', 'Email tidak ditemukan di data backup');
                            }
                        })
                        ->searchable(['nama', 'nim'])
                        ->live(debounce: 250)
                        ->preload()
                        ->columnSpanFull()
                        ->required(),
                    TextInput::make('email')
                        ->email()
                        ->maxLength(255)
                        ->readonly()
                        ->placeholder('Email akan terisi otomatis...'),
                    Select::make('roles')
                        ->label('Roles')
                        ->multiple()
                        ->relationship('roles', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
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
                        ->placeholder('Pilih salah satu pertanyaan keamanan')
                        ->searchPrompt('Ketik untuk mencari...'),
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
                        ->placeholder('Pilih salah satu pertanyaan keamanan')
                        ->searchPrompt('Ketik untuk mencari...'),
                    TextInput::make('a1') // <-- Jangan lupa field untuk jawabannya
                    ->label('Jawaban Keamanan 1'),
                    TextInput::make('a2') // <-- Jangan lupa field untuk jawabannya
                    ->label('Jawaban Keamanan 2'),
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
