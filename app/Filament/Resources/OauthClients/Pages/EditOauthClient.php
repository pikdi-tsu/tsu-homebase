<?php

namespace App\Filament\Resources\OauthClients\Pages;

use App\Filament\Resources\OauthClients\OauthClientResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOauthClient extends EditRecord
{
    protected static string $resource = OauthClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getFormActions(): array
    {
        $actions = parent::getFormActions();

        if (isset($actions[0])) {
            $actions[0]->color('secondary');
        }

        return $actions;
    }
}
