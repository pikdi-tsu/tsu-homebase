<?php

namespace App\Filament\Resources;

use App\Models\PertanyaanKeamanan;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\UserMahasiswaResource\Pages\ListUserMahasiswa;
use App\Filament\Resources\UserMahasiswaResource\Pages;
use App\Filament\Resources\UserMahasiswaResource\RelationManagers;
use App\Models\UserMahasiswa;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserMahasiswaResource extends Resource
{
    protected static ?string $model = UserMahasiswa::class;


    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'User Mahasiswa';
    protected static ?string $modelLabel = 'User Mahasiswa';
    protected static ?string $pluralModelLabel = 'User Mahasiswa';
    protected static ?string $recordTitleAttribute = 'name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['nim', 'name', 'email'];
    }

    public static function canViewAny(): bool
    {
        return Auth::user()->can('homebase:user-mahasiswa:view-any');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('homebase:user-mahasiswa:create');
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()->can('homebase:user-mahasiswa:update');
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()->can('homebase:user-mahasiswa:delete');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('nama mahasiswa')
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->required(),
                Select::make('roles')
                    ->label('Roles')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->getOptionLabelFromRecordUsing(fn (Role $record) => "{$record->name} ({$record->guard_name})")
                    ->searchable()
                    ->preload()
                    ->helperText('Format: Nama Roles (guard)')
                    ->required(),
                Select::make('permissions')
                    ->label('Izin Tambahan (Direct Permissions)')
                    ->multiple()
                    ->relationship('permissions', 'name')
                    ->getOptionLabelFromRecordUsing(fn (Permission $record) => "{$record->name} ({$record->guard_name})")
                    ->searchable()
                    ->preload()
                    ->helperText('Format: Nama Permission (guard)'),
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
                TextInput::make('a1') // <-- Jangan lupa field untuk jawabannya
                    ->label('Jawaban Keamanan 1'),
                TextInput::make('a2') // <-- Jangan lupa field untuk jawabannya
                    ->label('Jawaban Keamanan 2'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nim')
                    ->label('NIM mahasiswa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nama Mahasiswa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label('Role (Guard)')
                    ->badge()
                    ->color('secondary')
                    ->placeholder('Belum di set')
                    ->separator('<br>') // Gunakan <br> sebagai separator
                    ->getStateUsing(function (Model $record) {
                        if ($record->roles->isEmpty()) {
                            return null;
                        }
                        // Ubah implode menjadi return array biasa
                        return $record->roles->map(fn($role) => "{$role->name} ({$role->guard_name})")->all();
                    })
                    ->html() // <-- PENTING! Agar tag <br> dirender sebagai HTML
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->expandableLimitedList()
                    ->searchable(
                        query: function (Builder $query, string $search): Builder {
                            return $query->whereHas('roles', fn(Builder $q) => $q->where('name', 'like', "%{$search}%"));
                        }
                    ),
                TextColumn::make('permissions.name')
                    ->label('Izin Tambahan')
                    ->badge()
                    ->placeholder('Tidak ada izin tambahan')
                    ->color('success') // Beri warna berbeda agar mudah dibedakan dari roles
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->expandableLimitedList()
                    ->searchable(),
//                    ->tooltip(function (Model $record): string {
//                        // Spatie 'permissions' relationship hanya mengambil direct permissions
//                        return $record->permissions->pluck('name')->implode(', ');
//                    }),
                TextColumn::make('q1')
                    ->label('Pertanyaan Keamanan 1')
                    ->formatStateUsing(fn (string $state): string => "{$state}?")
                    ->placeholder('Belum di set')
                    ->searchable(),
                TextColumn::make('a1')
                    ->label('Jawaban Keamanan 1')
                    ->placeholder('Belum di set')
                    ->searchable(),
                TextColumn::make('q2')
                    ->label('Pertanyaan Keamanan 2')
                    ->formatStateUsing(fn (string $state): string => "{$state}?")
                    ->placeholder('Belum di set')
                    ->searchable(),
                TextColumn::make('a2')
                    ->label('Jawaban Keamanan 2')
                    ->placeholder('Belum di set')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->color('warning'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['roles', 'permissions']);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUserMahasiswa::route('/'),
//            'create' => Pages\CreateUserMahasiswa::route('/create'),
            'edit' => Pages\EditUserMahasiswa::route('/{record}/edit'),
        ];
    }
}
