<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaturasResource\Pages;

use App\Models\Faturas;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel='Fatura';
    protected static ?string $pluralModelLabel='Faturas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('expires_at')->native(false)->label('Data de Vencimento'),
                Checkbox::make('paid')->label('Pago'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                BooleanColumn::make('paid')->label('Pago'),
                TextColumn::make('expires_at')->date('Y/m')->label('Data de vencimentos')
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
