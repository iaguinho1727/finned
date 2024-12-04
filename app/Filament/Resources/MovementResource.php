<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovementResource\Pages;
use App\Filament\Resources\MovementResource\RelationManagers;
use App\Models\Movement;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Database\Eloquent\Collection;
class MovementResource extends Resource
{
    protected static ?string $model = Movement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('participant_id')
                ->searchable()
                ->required()
                ->preload()
                ->createOptionForm([
                    TextInput::make('name')->label('Nome')
                ])->native(false)
                ->editOptionForm([
                    TextInput::make('name')->label('Nome')
                ])

                ->relationship('participant','name')->label('Participant'),

                Select::make('movement_type')->options([
                    'debit'=>'Débito',
                    'credit'=>'Crédito',
                    'pix'=>'Pix',
                    'money'=>'Dinherio',
                    'transfer'=>'Transferência',
                    'other'=>'Outro'
                ])->label('Tipo de Movimento')->default('pix'),

                DatePicker::make('movement_date')->displayFormat('d/m/Y')->required()->label('Data da Movimentação')->native(false),

                TextInput::make('value')->label('Valor')->numeric(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('participant.name')->label('Particpante')->searchable(),
                TextInputColumn::make('value')->summarize(Sum::make()->label('Total'))->sortable()
                ->type('number')->label('Valor'),
                TextColumn::make('movement_date')->sortable()->date('d/m/Y')->label('Data da Movimentação'),
                SelectColumn::make('movement_type')->options([
                    'debit'=>'Débito',
                    'credit'=>'Crédito',
                    'pix'=>'Pix',
                    'money'=>'Dinherio',
                    'transfer'=>'Transferência',
                    'other'=>'Outro'
                ])->label('Tipo de Movimentação')->alignCenter(),
                TextColumn::make('created_at')->dateTime(),
            ])->defaultSort('movement_date','desc')

            ->filters([
                SelectFilter::make('parcicipant')->relationship('participant','name')->searchable()->preload(),


                QueryBuilder::make()->constraints([
                    DateConstraint::make('movement_date')
                ])
            ])
            ->actions([

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('Edição Múltipla')


                    ->form([
                        Select::make('participant_id')

                        ->createOptionForm([
                            TextInput::make('name')->label('Nome')
                        ])->native(false)
                        ->searchable()
                        ->preload()
                        ->relationship('participant','name')->label('Participant'),


                    ])->action(function(array $data,Collection $records){
                        $new_participant_id=$data['participant_id'];
                        $records->each(fn($item)=>$item->update(['participant_id'=>$new_participant_id]));


                    })
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMovements::route('/'),
        ];
    }
}
