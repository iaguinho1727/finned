<?php

namespace App\Filament\Resources\MonthlyMovementsResource\Pages;

use App\Filament\Resources\MonthlyMovementsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMonthlyMovements extends EditRecord
{
    protected static string $resource = MonthlyMovementsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
