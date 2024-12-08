<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MealsResource\Pages;
use App\Filament\Resources\MealsResource\RelationManagers;
use App\Models\Foods;
use App\Models\Meals;
use App\Models\Units;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MealsResource extends Resource
{
    protected static ?string $model = Meals::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel='Refeição';

    protected static ?string $pluralModelLabel='Refeições';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('food_id')->native(false)->relationship('foods','name')->label('Comida'),


                Select::make('unit_id')->relationship('unidade','name')->native(false),

                TextInput::make('unit')->label('Valor unitário')->default(1),


                DateTimePicker::make('ate_at')
                ->format('d/m/Y H:i')
                ->label('Comeu em')->time()->date()->native(false)->seconds(false)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ate_at')->dateTime('d/m/Y H:i')->label('Comeu em'),

                TextColumn::make('unit')->numeric(),
                TextColumn::make('unidade.name')->label('Valor unitário'),
                TextColumn::make('foods.name')->label('Comida'),
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
            'index' => Pages\ListMeals::route('/'),
            'create' => Pages\CreateMeals::route('/create'),
            'edit' => Pages\EditMeals::route('/{record}/edit'),
        ];
    }
}
