<?php

namespace App\Filament\Resources\FaturasResource\Pages;

use App\Filament\Resources\FaturasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFaturas extends EditRecord
{
    protected static string $resource = FaturasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
