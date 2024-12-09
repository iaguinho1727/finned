<?php

namespace App\Filament\Resources\SleepEvaluationResource\Pages;

use App\Filament\Resources\SleepEvaluationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSleepEvaluation extends EditRecord
{
    protected static string $resource = SleepEvaluationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
