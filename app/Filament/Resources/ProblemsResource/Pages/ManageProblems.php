<?php

namespace App\Filament\Resources\ProblemsResource\Pages;

use App\Filament\Resources\ProblemsResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProblems extends ManageRecords
{
    protected static string $resource = ProblemsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
