<?php

namespace App\Filament\Resources\MovementResource\Pages;

use App\Filament\Exports\MovementExporter;
use App\Filament\Imports\MovementImporter;
use App\Filament\Resources\MovementResource;
use App\Models\Movement;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ManageRecords;

class ManageMovements extends ManageRecords
{
    protected static string $resource = MovementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()->importer(MovementImporter::class),
            ExportAction::make()->exporter(MovementExporter::class),






        ];
    }
}
