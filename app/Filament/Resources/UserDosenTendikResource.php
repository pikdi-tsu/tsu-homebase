<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\BackupUsersDosenTendik;
use App\Models\UserDosenTendik;
use App\Services\DefaultPasswordService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Pages\Page; // Jangan lupa tambahkan ini di atas
use Filament\Resources\Pages\CreateRecord; // dan ini juga

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserDosenTendikResource extends Resource
{
    protected static ?string $model = UserDosenTendik::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'User Dosen & Tendik';
    protected static ?string $modelLabel = 'User Dosen & Tendik';
    protected static ?string $pluralModelLabel = 'User Dosen & Tendik';

    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        // Panggil service untuk mendapatkan password yang sudah di-hash
        $data['password'] = (new DefaultPasswordService())->getDefaultHashedPassword();

        return $data;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('Nama Dosen/Tendik')
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
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->disabled(),
//                Forms\Components\DateTimePicker::make('email_verified_at'),
//                Forms\Components\TextInput::make('password')
//                    ->password()
//                    ->required()
//                    ->maxLength(255)
//                    ->disabled(),
//                Forms\Components\select::make('password_confirmation')
//                Forms\Components\TextInput::make('current_team_id')
//                    ->numeric(),
//                Forms\Components\TextInput::make('profile_photo_path')
//                    ->maxLength(2048),
//                Forms\Components\Textarea::make('two_factor_secret')
//                    ->columnSpanFull(),
//                Forms\Components\Textarea::make('two_factor_recovery_codes')
//                    ->columnSpanFull(),
//                Forms\Components\DateTimePicker::make('two_factor_confirmed_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
//                Tables\Columns\TextColumn::make('email_verified_at')
//                    ->dateTime()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('current_team_id')
//                    ->numeric()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('profile_photo_path')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('created_at')
//                    ->dateTime()
//                    ->sortable()
//                    ->toggleable(isToggledHiddenByDefault: true),
//                Tables\Columns\TextColumn::make('updated_at')
//                    ->dateTime()
//                    ->sortable()
//                    ->toggleable(isToggledHiddenByDefault: true),
//                Tables\Columns\TextColumn::make('two_factor_confirmed_at')
//                    ->dateTime()
//                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUserDosenTendik::route('/'),
//            'create' => Pages\CreateUserDosenTendik::route('/create'),
            'edit' => Pages\EditUserDosenTendik::route('/{record}/edit'),
        ];
    }
}
