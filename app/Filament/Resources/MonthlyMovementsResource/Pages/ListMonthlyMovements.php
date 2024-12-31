<?php

namespace App\Filament\Resources\MonthlyMovementsResource\Pages;

use App\Filament\Resources\MonthlyMovementsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMonthlyMovements extends ListRecords
{
    protected static string $resource = MonthlyMovementsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
