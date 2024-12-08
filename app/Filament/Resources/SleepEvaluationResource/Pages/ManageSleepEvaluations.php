<?php

namespace App\Filament\Resources\SleepEvaluationResource\Pages;

use App\Filament\Resources\SleepEvaluationResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSleepEvaluations extends ManageRecords
{
    protected static string $resource = SleepEvaluationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
