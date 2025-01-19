<?php

namespace App\Filament\Resources\MovementResource\RelationManagers;

use App\Filament\Resources\ParticipantResource;
use App\Models\Product;
use App\Models\Units;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('product_id') ->options(Product::all()->pluck('name','id'))
                ->native(false)->label('Produtos')
                    ->required(),

                Select::make('unit_id')->native(false)->searchable()->preload()
                ->options(Units::all()->pluck('name','id'))->label('Unidade'),

                TextInput::make('quantity')->label('Quantidade'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                TextColumn::make('quantity')->label('Quantidade'),
                TextColumn::make('unit_id')->label('Unidade')

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                DetachAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    DetachBulkAction::make()
                ]),
            ]);
    }
}
