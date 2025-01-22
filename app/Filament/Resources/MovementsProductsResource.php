<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovementsProductsResource\Pages;
use App\Filament\Resources\MovementsProductsResource\RelationManagers;
use App\Models\Movement;
use App\Models\MovementsProducts;
use Carbon\Carbon;
use Filament\Actions\DeleteAction;
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

class MovementsProductsResource extends Resource
{
    protected static ?string $model = MovementsProducts::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel='Produto & Movimentação';

    protected static ?string $pluralModelLabel='Produtos e Movimentações';

    protected static ?string $navigationGroup='Finanças';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('movement_id')
                ->relationship('movements')
                ->searchable()
                ->preload()
                ->required()
                ->native(false)
                ->getOptionLabelFromRecordUsing(fn(Movement $record)=>$record->participant->name. " - ".
                Carbon::parse($record->movement_date)->format('d/m/Y'))
                ,

                Select::make('product_id')->createOptionForm([
                    TextInput::make('name')->label('Nome')
                ])->required()->native(false)->searchable()
                ->preload()->relationship('products','name')->label('Produto'),

                Select::make('unit_id')
                ->createOptionForm([
                    TextInput::make('name')->label('Nome')
                ])->required()

                ->relationship('units','name')->label('Unidade')->native(false)
                ->searchable()->preload(),

                TextInput::make('total')->required()->label('Valor')->numeric(),

                TextInput::make('quantity')->required()->label('Quantidade')->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('movements.participant.name')->label('Participante'),
                TextColumn::make('movements.movement_date')->sortable()->date('d/m/Y')->label('Data da movimentação'),
                TextColumn::make('total')->label('Valor'),
                TextColumn::make('products.name')->label('Produto'),
                TextColumn::make('units.name')->label('Unidade'),
                TextColumn::make('quantity')->label('Quantidade')
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                \Filament\Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListMovementsProducts::route('/'),
            'create' => Pages\CreateMovementsProducts::route('/create'),
            'edit' => Pages\EditMovementsProducts::route('/{record}/edit'),
        ];
    }
}
