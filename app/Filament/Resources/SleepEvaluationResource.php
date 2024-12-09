<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SleepEvaluationResource\Pages;
use App\Models\SleepEvaluation;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class SleepEvaluationResource extends Resource
{
    protected static ?string $model = SleepEvaluation::class;

    protected static ?string $navigationIcon = 'bi-moon';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('note')->label('Nota')->required()->default(0),
                Select::make('problem_id')->relationship('problems','name')->label('Problema')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('note')->label('Nota'),
                TextColumn::make('problems.name')->label('Problema'),
                TextColumn::make('created_at')->label('Data de criação')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSleepEvaluations::route('/'),
            'create' => Pages\CreateSleepEvaluation::route('/create'),
            'edit' => Pages\EditSleepEvaluation::route('/{record}/edit'),
        ];
    }
}
