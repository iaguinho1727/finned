<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsumptionResource\Pages;
use App\Filament\Resources\ConsumptionResource\RelationManagers;
use App\Models\Consumption;
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

class ConsumptionResource extends Resource
{
    protected static ?string $model = Consumption::class;

    protected static ?string $navigationIcon = 'bi-lightning-charge';

    protected static ?string $navigationGroup='Consumo';

    protected static ?string $modelLabel='Consumo';

    protected static ?string $pluralModelLabel='Consumos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('consumable_id')->relationship('consumable','name')->native(false)
                ->preload()->searchable()->required(),

                Select::make('unit_id')->live()->relationship('unit','name')->label('Unidade')->preload()
                ->searchable()->required(),

                TextInput::make('quantity')->dehydrated()->disabled(fn($get)=>str($get('unit_id'))->isEmpty())
                ->label('Quantidade Unitária')->numeric()->required(),

                TextInput::make('hours_consumed')->numeric()->label('Horas de Consumo'),

                TextInput::make('casa'),

                TextInput::make('comodo')


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('consumable.name')->label('Consumivel'),
                TextColumn::make('quantity')->label('Quantidade'),
                TextColumn::make('unit.name')->badge()->label('Unidade'),
                TextColumn::make('comodo'),
                TextColumn::make('casa')
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
            'index' => Pages\ListConsumptions::route('/'),
            'create' => Pages\CreateConsumption::route('/create'),
            'edit' => Pages\EditConsumption::route('/{record}/edit'),
        ];
    }
}
