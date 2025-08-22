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
use Illuminate\Support\Str;

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
                        ->label('NIK - Nama Dosen/Tendik')
                        ->searchable(['nama', 'nip'])
//                        ->options(BackupUsersDosenTendik::all()->pluck('nama_lengkap_dan_nip', 'nip'))
                        ->placeholder('Ketik nama atau NIK untuk mencari...')
                        ->getSearchResultsUsing(function (string $search): array {
                            if (strlen($search) < 3) {
                                return [];
                            }
                            return BackupUsersDosenTendik::query()
                                ->where('nama', 'like', "%{$search}%")
                                ->orWhere('nip', 'like', "%{$search}%")
                                ->limit(50)
                                ->get()
                                ->pluck('nama_lengkap_dan_nip', 'nip')
                                ->all();
                        })
                        ->getOptionLabelUsing(function ($value): ?string {
                            return BackupUsersDosenTendik::where('nip', $value)->first()?->nama_lengkap_dan_nip;
                        })
//                        ->getOptionLabelsUsing(fn (string $value): array => BackupUsersDosenTendik::query()
//                            ->where('nip', $value)?->pluck('nama', 'nip')->all())
                        ->live(debounce: 500)
//                        ->formatStateUsing(function (?string $state): ?string {
//                            \Log::info($state);
//                            if (!$state) return null;
//
//                            $user = BackupUsersDosenTendik::where('nip', $state)->first();
//                            if (!$user) return $state;
//
//                            // Ambil nama lengkap dari accessor
//                            $namaLengkap = $user->nama_lengkap_dan_nip;
//
//                            // Potong teks jika lebih dari 40 karakter, tambahkan "..."
//                            return Str::limit($namaLengkap, 20);
//                        })
                        ->afterStateUpdated(function ($state, callable $set, Select $component) {
//                            dd($state);
                            if (is_null($state)) {
                                $set('email', null);
                                return;
                            }

                            $user = BackupUsersDosenTendik::where('nip', $state)->first();
                            if ($user) {
                                $set('email', $user->email_kampus);
                            } else {
                                $set('email', 'Email tidak ditemukan di data backup');
                            }
                        })
                        ->preload()
                        ->required(),
                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->readonly()
                        ->placeholder('Email akan terisi otomatis...'),
                    Select::make('q1')
                        ->label('Pertanyaan Keamanan 1')
                        ->options(
                            PertanyaanKeamanan::where('jenis', 'q1')->get() // 1. Ambil semua data sebagai collection
                            ->mapWithKeys(function ($item) { // 2. Lakukan iterasi untuk setiap item
                                // 3. Buat array [id => "Pertanyaan... ?"]
                                return [$item->id => $item->pertanyaan . '?'];
                            })
                        )
                        ->searchable(),
                    Select::make('q2') // Ini akan menyimpan ID pertanyaan
                        ->label('Pertanyaan Keamanan 2')
                        ->options(
                            PertanyaanKeamanan::where('jenis', 'q2')->get() // 1. Ambil semua data sebagai collection
                            ->mapWithKeys(function ($item) { // 2. Lakukan iterasi untuk setiap item
                                // 3. Buat array [id => "Pertanyaan... ?"]
                                return [$item->id => $item->pertanyaan . '?'];
                            })
                        )
                        ->searchable(),
                    TextInput::make('a1')
                    ->label('Jawaban Keamanan 1'),
                    TextInput::make('a2')
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
