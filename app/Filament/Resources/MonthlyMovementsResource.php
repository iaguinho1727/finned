<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MonthlyMovementsResource\Pages;
use App\Filament\Resources\MonthlyMovementsResource\RelationManagers;
use App\Models\MonthlyMovements;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MonthlyMovementsResource extends Resource
{
    protected static ?string $model = MonthlyMovements::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel='Gasto Mensal';

    protected static ?string $pluralModelLabel='Gastos Mensais';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('participant_id')->relationship('participant','name')
                ->label('Participant')->native(false)->preload()->searchable(),

                TextInput::make('value')->required()->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('participant.name')->label('Participant'),
                TextColumn::make('value')->label('Value'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMonthlyMovements::route('/'),
            'create' => Pages\CreateMonthlyMovements::route('/create'),
            'edit' => Pages\EditMonthlyMovements::route('/{record}/edit'),
        ];
    }
}
