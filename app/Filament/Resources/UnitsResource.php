<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitsResource\Pages;
use App\Filament\Resources\UnitsResource\RelationManagers;
use App\Models\Units;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UnitsResource extends Resource
{
    protected static ?string $model = Units::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Unidade')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextInputColumn::make('name')->label('Unidade')
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
            'index' => Pages\ListUnits::route('/'),
            'create' => Pages\CreateUnits::route('/create'),
            'edit' => Pages\EditUnits::route('/{record}/edit'),
        ];
    }
}
