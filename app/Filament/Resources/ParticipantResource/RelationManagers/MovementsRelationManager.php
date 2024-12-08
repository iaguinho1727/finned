<?php

namespace App\Filament\Resources\ParticipantResource\RelationManagers;

use App\Filament\Resources\MovementResource;
use App\Models\Movement;
use Filament\Actions\CreateAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\Summarizers\Sum;
use Illuminate\Support\Collection;
class MovementsRelationManager extends RelationManager
{
    protected static string $relationship = 'movements';

    public function form(Form $form): Form
    {
        $new_form=MovementResource::form($form);


        return $new_form;
    }

    public function table(Table $table): Table
    {
        return MovementResource::table($table)
        ->headerActions([
            \Filament\Tables\Actions\CreateAction::make(),
            AttachAction::make()->multiple(),

        ])
        ->recordTitle(fn (Movement $record): string => "{$record->participant->name} ({$record->movement_date})");
    }
}
