<?php

namespace App\Filament\Resources\ParticipantResource\Pages;

use App\Filament\Exports\ParticipantExporter;
use App\Filament\Imports\ParticipantImporter;
use App\Filament\Resources\ParticipantResource;
use App\Models\Participant;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ManageRecords;

class ManageParticipants extends ManageRecords
{
    protected static string $resource = ParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make()->exporter(ParticipantExporter::class),
            ImportAction::make()->importer(ParticipantImporter::class)
        ];
    }
}
