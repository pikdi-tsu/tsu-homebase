<?php

namespace App\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use app\Models\UserDosenTendik;

class LatestUsersDosenTendikWidget extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => UserDosenTendik::query()->latest()->limit(5))
            ->columns([
                TextColumn::make('nik')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('is_active'),
                TextColumn::make('last_login_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                Action::make('View')
                    ->url(fn (UserDosenTendik $record): string => route('filament.admin.resources.user-dosen-tendiks.edit', $record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
