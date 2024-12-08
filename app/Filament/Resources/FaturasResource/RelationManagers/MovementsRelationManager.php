<?php

namespace App\Filament\Resources\FaturasResource\RelationManagers;

use App\Filament\Resources\MovementResource;
use App\Models\Movement;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MovementsRelationManager extends RelationManager
{
    protected static string $relationship = 'movements';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Select::make('participant_id')
            ->searchable()
            ->required()
            ->preload()
            ->createOptionForm([
                TextInput::make('name')->label('Nome')
            ])->native(false)
            ->editOptionForm([
                TextInput::make('name')->label('Nome')
            ])

            ->relationship('participant','name')->required()->label('Participant'),

            Select::make('movement_type')->options([

                'credit'=>'Crédito',
            ])->required()->label('Tipo de Movimento')->default('credit'),

            Select::make('categories_id')->label('Categoria')
            ->createOptionForm([
                TextInput::make('name')->label('Nome')
            ])
            ->relationship('categories','name')->preload()->searchable(),

            DatePicker::make('movement_date')->required()->displayFormat('d/m/Y')->required()->label('Data da Movimentação')->native(false),

            TextInput::make('value')->required()->label('Valor')->numeric(),

        ]);
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
