<?php

namespace App\Filament\Resources\FaturasResource\Pages;

use App\Filament\Resources\FaturasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFaturas extends ListRecords
{
    protected static string $resource = FaturasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
