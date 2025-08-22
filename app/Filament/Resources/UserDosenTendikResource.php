<?php

namespace App\Filament\Resources;

use App\Models\PertanyaanKeamanan;
use Filament\Actions\CreateAction;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\UserDosenTendikResource\Pages\CreateUserDosenTendik;
use App\Filament\Resources\UserDosenTendikResource\Pages\ListUserDosenTendik;
use App\Filament\Resources\UserDosenTendikResource\Pages\EditUserDosenTendik;
use App\Filament\Resources\UserDosenTendikResource\Pages;
use App\Filament\Resources\UserDosenTendikResource\RelationManagers;
use App\Models\BackupUsersDosenTendik;
use App\Models\UserDosenTendik;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Pages\Page; // Jangan lupa tambahkan ini di atas
use Filament\Resources\Pages\CreateRecord; // dan ini juga

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserDosenTendikResource extends Resource
{
    protected static ?string $model = UserDosenTendik::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'User Dosen & Tendik';
    protected static ?string $modelLabel = 'User Dosen & Tendik';
    protected static ?string $pluralModelLabel = 'User Dosen & Tendik';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('nama dosen/tendik')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nik')
                    ->label('NIK dosen/tendik')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nama Dosen/Tendik')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('pertanyaanKeamananSatu.pertanyaan')
                    ->label('Pertanyaan Keamanan 1')
                    ->formatStateUsing(fn (string $state): string => "{$state}?")
                    ->searchable(),
                TextColumn::make('a1')
                    ->label('Jawaban Keamanan 1')
                    ->searchable(),
                TextColumn::make('pertanyaanKeamananDua.pertanyaan')
                    ->label('Pertanyaan Keamanan 2')
                    ->formatStateUsing(fn (string $state): string => "{$state}?")
                    ->searchable(),
                TextColumn::make('a2')
                    ->label('Jawaban Keamanan 2')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => ListUserDosenTendik::route('/'),
//            'create' => CreateUserDosenTendik::route('/create'),
            'edit' => EditUserDosenTendik::route('/{record}/edit'),
        ];
    }
}
