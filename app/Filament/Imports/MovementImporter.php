<?php

namespace App\Filament\Imports;

use App\Models\Movement;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class MovementImporter extends Importer
{
    protected static ?string $model = Movement::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('value')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('parcela')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('participant')
                ->requiredMapping()
                ->relationship('name')
                ->rules(['required']),
            ImportColumn::make('movement_date')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('movement_type')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
        ];
    }

    public function resolveRecord(): ?Movement
    {
        // return Movement::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Movement();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your movement import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
