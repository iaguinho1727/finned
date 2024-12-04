<?php

namespace App\Filament\Exports;

use App\Models\Movement;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class MovementExporter extends Exporter
{
    protected static ?string $model = Movement::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('value'),
            ExportColumn::make('parcela'),
            ExportColumn::make('participant.name'),
            ExportColumn::make('movement_date'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('movement_type'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your movement export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
