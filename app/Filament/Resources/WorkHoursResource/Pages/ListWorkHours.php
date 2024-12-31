<?php

namespace App\Filament\Resources\WorkHoursResource\Pages;

use App\Filament\Resources\WorkHoursResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorkHours extends ListRecords
{
    protected static string $resource = WorkHoursResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
