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
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

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
                        ->placeholder('Pilih salah satu data Karyawan')
//                        ->options(BackupUsersDosenTendik::all()->pluck('nama_lengkap_dan_nip', 'nip'))
                        ->searchPrompt('Ketik NIK atau Nama untuk mencari...')
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
                        ->searchable(['nama', 'nip'])
                        ->live(debounce: 500)
                        ->preload()
                        ->columnSpanFull()
                        ->required(),
                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->readonly()
                        ->columnSpanFull()
                        ->placeholder('Email akan terisi otomatis...'),
                    Select::make('roles')
                        ->label('Jabatan (Roles)')
                        ->multiple()
                        ->relationship('roles', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('permissions')
                        ->label('Izin Tambahan (Direct Permissions)')
                        ->relationship('permissions','name',
                            function (Builder $query, Get $get) {
                                // Ambil roles yang sedang dipilih
                                $roles = Role::find($get('roles'));
                                if (!$roles->count()) {
                                    return $query;
                                }
                                // Ambil guard dari role pertama yang dipilih
                                $guard = $roles->first()->guard_name;

                                // Filter permission berdasarkan guard tersebut
                                return $query->where('guard_name', $guard);
                            }
                        )
                        ->searchable()
                        ->multiple()
                        ->preload(),
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
