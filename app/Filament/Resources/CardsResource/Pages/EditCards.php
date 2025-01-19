<?php

namespace App\Filament\Resources\CardsResource\Pages;

use App\Filament\Resources\CardsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCards extends EditRecord
{
    protected static string $resource = CardsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
