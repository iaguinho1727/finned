<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FoodsResource\Pages;
use App\Filament\Resources\FoodsResource\RelationManagers;
use App\Models\Foods;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FoodsResource extends Resource
{
    protected static ?string $model = Foods::class;

    protected static ?string $navigationIcon = 'bi-egg-fried';

    protected static ?string $modelLabel='Comida';

    protected static ?string $pluralModelLabel='Comidas';

    public static function form(Form $form): Form
    {
        return ParticipantResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return ParticipantResource::table($table);
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
            'index' => Pages\ListFoods::route('/'),
            'create' => Pages\CreateFoods::route('/create'),
            'edit' => Pages\EditFoods::route('/{record}/edit'),
        ];
    }
}
