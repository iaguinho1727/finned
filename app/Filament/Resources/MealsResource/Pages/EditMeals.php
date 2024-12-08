<?php

namespace App\Filament\Resources\MealsResource\Pages;

use App\Filament\Resources\MealsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMeals extends EditRecord
{
    protected static string $resource = MealsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
