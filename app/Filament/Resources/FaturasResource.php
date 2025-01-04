<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaturasResource\Pages;


use App\Filament\Resources\FaturasResource\RelationManagers\MovementsRelationManager;
use App\Models\Faturas;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FaturasResource extends Resource
{
    protected static ?string $model = Faturas::class;

    protected static ?string $navigationIcon = 'bi-receipt';

    protected static ?string $modelLabel='Fatura';
    protected static ?string $pluralModelLabel='Faturas';

    protected static ?string $navigationGroup='Finanças';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('expires_at')->required()->native(false)->label('Data de Vencimento'),
                Select::make('bank_id')->relationship('banks','name')->label('Banco')->required(),

                DatePicker::make('pago_em')->native(false)->date()->time()->required()->label('Pago'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pago_em')->label('Pago em')->date('Y/m/d')->time(),
                TextColumn::make('expires_at')->date('Y/m')->label('Data de vencimentos'),
                TextColumn::make('banks.name')->label('Banco')
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
            MovementsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFaturas::route('/'),
            'create' => Pages\CreateFaturas::route('/create'),
            'edit' => Pages\EditFaturas::route('/{record}/edit'),
        ];
    }
}
