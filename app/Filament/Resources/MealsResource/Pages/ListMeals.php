<?php

namespace App\Filament\Resources\MealsResource\Pages;

use App\Filament\Resources\MealsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMeals extends ListRecords
{
    protected static string $resource = MealsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
