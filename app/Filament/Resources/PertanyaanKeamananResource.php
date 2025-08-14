<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PertanyaanKeamananResource\Pages;
use App\Filament\Resources\PertanyaanKeamananResource\RelationManagers;
use App\Models\PertanyaanKeamanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PertanyaanKeamananResource extends Resource
{
    protected static ?string $model = PertanyaanKeamanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pertanyaan Keamanan';

    protected static ?string $modelLabel = 'Pertanyaan Keamanan';

    protected static ?string $pluralModelLabel = 'Pertanyaan Keamanan';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('jenis')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pertanyaan')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jenis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pertanyaan')
                    ->searchable(),
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
            'index' => Pages\ListPertanyaanKeamanans::route('/'),
//            'create' => Pages\CreatePertanyaanKeamanan::route('/create'),
            'edit' => Pages\EditPertanyaanKeamanan::route('/{record}/edit'),
        ];
    }
}
