<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CardsResource\Pages;
use App\Filament\Resources\CardsResource\RelationManagers;
use App\Models\Cards;
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

class CardsResource extends Resource
{
    protected static ?string $model = Cards::class;

    protected static ?string $navigationIcon = 'bi-credit-card-2-back-fill';

    protected static ?string $modelLabe='Cartão';
    protected static ?string $pluralModelLabel='Cartões';

    protected static ?string $navigationGroup='Finanças';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Nome'),

                Select::make('expire_at')->default(1)->options(
                    collect()->range(1,31)->mapWithKeys(fn($item)=>[$item=>$item])->toArray()
                    )->label('Dia de Vencimento da Fatura'),
                Select::make('closes_at')->default(1)->options(
                    collect()->range(1,31)->mapWithKeys(fn($item)=>[$item=>$item])->toArray())->label('Dia de fechamento da Fatura')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Identificado'),
                TextColumn::make('expire_at')->label('Dia de Vencimento'),
                TextColumn::make('closes_at')->label('Dia de Fechamento')
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
            'index' => Pages\ListCards::route('/'),
            'create' => Pages\CreateCards::route('/create'),
            'edit' => Pages\EditCards::route('/{record}/edit'),
        ];
    }
}
