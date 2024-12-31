<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkHoursResource\Pages;
use App\Filament\Resources\WorkHoursResource\RelationManagers;
use App\Models\WorkHours;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorkHoursResource extends Resource
{
    protected static ?string $model = WorkHours::class;

    protected static ?string $navigationIcon = 'bi-alarm';

    protected static ?string $modelLabel='Horas Úteis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('begin_date')
                ->live()
                ->native(false)->displayFormat('d/m/Y')->label('Começo do Mês'),

                TextInput::make('hours')->numeric()->label('Horas'),

                TextInput::make('bussiness_hours')
                ->numeric()
                ->label('Horas Normais')->disabled()->dehydrated()

                ->formatStateUsing(function($get){
                    if(str($get('begin_date'))->isNotEmpty())
                    {
                        return  number_format(Carbon::parse($get('begin_date'))->getBusinessDaysInMonth()*8.48,2);
                    }
                } ),

                TextInput::make('bussiness_days')->numeric()->disabled()->dehydrated()
                ->formatStateUsing(function($get){
                    if(str($get('begin_date'))->isNotEmpty())
                    {
                        return Carbon::parse($get('begin_date'))->getBusinessDaysInMonth();
                    }
                })

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('begin_date')->label('Começo'),
                TextInputColumn::make('hours')->type('numeric')->label('Horas'),
                TextColumn::make('bussiness_days')->label('Dais úties')
                ->summarize(Sum::make()->label('Total Dias')),
                TextColumn::make('bussiness_hours')->label('Horas ùties')
                ->summarize(Sum::make()->label('Total Horas')),

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
            'index' => Pages\ListWorkHours::route('/'),
            'create' => Pages\CreateWorkHours::route('/create'),
            'edit' => Pages\EditWorkHours::route('/{record}/edit'),
        ];
    }
}
