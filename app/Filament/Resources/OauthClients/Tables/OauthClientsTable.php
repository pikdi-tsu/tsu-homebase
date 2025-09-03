<?php

namespace App\Filament\Resources\OauthClients\Tables;

use App\Models\OauthCLient;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class OauthClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Modul')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('id')
                    ->label('Client ID')
                    ->copyable(),
                TextColumn::make('secret')
                    ->label('Client Secret')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('grant_types')
                    ->label('Tipe Grant')
                    ->badge(),
                ToggleColumn::make('revoked')
                    ->label('Akses Dicabut'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),

                Action::make('regenerateSecret')
                    ->label('Regenerate Secret')
                    ->icon('heroicon-o-arrow-path')
                    ->color('danger') // Beri warna bahaya agar tidak sembarang diklik
                    ->requiresConfirmation() // Minta konfirmasi
                    ->action(function (OauthCLient $record) {
                        $newSecret = Str::random(40);
                        $record->forceFill(['secret' => $newSecret])->save();

                        Notification::make()
                            ->title('Secret Baru Berhasil Dibuat')
//                            ->body("Secret baru untuk klien '{$record->name}' adalah: {$newSecret}")
                            ->body("Secret Key baru {$record->name} sudah siap. Klik tombol di bawah untuk menyalin.")
                            ->persistent()
                            ->actions([
                                Action::make('copyNewSecret')
                                    ->label('Salin Secret Key')
                                    ->button()
                                    ->color('gray')
                                    ->icon('heroicon-o-clipboard-document')
                                    ->dispatch('copy-to-clipboard', [
                                        'token' => $newSecret,
                                    ])
                                ])
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
