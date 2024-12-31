<?php

namespace App\Filament\Resources\WorkHoursResource\Pages;

use App\Filament\Resources\WorkHoursResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkHours extends EditRecord
{
    protected static string $resource = WorkHoursResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
