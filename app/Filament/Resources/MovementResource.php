<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovementResource\Pages;
use App\Filament\Resources\MovementResource\RelationManagers;
use App\Filament\Resources\MovementResource\RelationManagers\ProductsRelationManager;
use App\Filament\Resources\ParticipantResource\RelationManagers\MovementsRelationManager;
use App\Models\Movement;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Database\Eloquent\Collection;
class MovementResource extends Resource
{
    protected static ?string $model = Movement::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $pluralModelLabel= 'Movimentações';


    protected static ?string $modelLabel='Movimentação';

    protected static ?string $navigationGroup='Finanças';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('participant_id')
                ->hiddenOn(MovementsRelationManager::class)
                ->searchable()
                ->required()
                ->preload()
                ->createOptionForm([
                    TextInput::make('name')->label('Nome')
                ])->native(false)
                ->editOptionForm([
                    TextInput::make('name')->label('Nome')
                ])

                ->relationship('participant','name')->required()->label('Participant'),

                Select::make('movement_type')->options([
                    'debit'=>'Débito',
                    'credit'=>'Crédito',
                    'pix'=>'Pix',
                    'money'=>'Dinherio',
                    'transfer'=>'Transferência',
                    'other'=>'Outro'
                ])->required()->live()->label('Tipo de Movimento')->default('pix'),

                Select::make('categories_id')->label('Categoria')
                ->createOptionForm([
                    TextInput::make('name')->label('Nome')
                ])
                ->relationship('categories','name')->preload()->searchable(),

                DatePicker::make('movement_date')->required()->displayFormat('d/m/Y')->required()->label('Data da Movimentação')->native(false),

                TextInput::make('value')->required()->label('Valor')->numeric(),

                Select::make('card_id')
                ->dehydrated()
                ->disabled(fn($get)=>$get('movement_type')!='credit')
                ->relationship('cards','name')->label('Cartão')

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
                TextColumn::make('categories.name')->badge()->label('Categoria'),


            ])->defaultSort('movement_date','desc')

            ->filters([
                SelectFilter::make('parcicipant')->relationship('participant','name')->searchable()->preload(),

                SelectFilter::make('categories_id')->label('Categoria')->relationship('categories','name')->searchable()->preload(),
                SelectFilter::make('movement_type')->options(
                    [
                        'debit'=>'Débito',
                        'credit'=>'Crédito',
                        'pix'=>'Pix',
                        'money'=>'Dinherio',
                        'transfer'=>'Transferência',
                        'other'=>'Outro'
                    ]
                    )->label('Tipo de Movimento'),


                QueryBuilder::make()->constraints([
                    NumberConstraint::make('value')->label('Valor'),
                    DateConstraint::make('movement_date')
                ])
            ])
            ->actions([

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                ReplicateAction::make(),
                AttachAction::make(),


            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    DetachBulkAction::make(),
                    BulkAction::make('Edição Múltipla')


                    ->form([
                        Select::make('participant_id')

                        ->createOptionForm([
                            TextInput::make('name')->label('Nome')
                        ])->native(false)
                        ->searchable()
                        ->preload()
                        ->relationship('participant','name')->label('Participant'),

                        Select::make('categories_id')
                        ->createOptionForm([
                            TextInput::make('name')->label('Nome')
                        ])->native(false)
                        ->relationship('categories','name')
                        ->preload()
                        ->searchable()
                        ->native(false)


                    ])->action(function(array $data,Collection $records){
                        $new_data=collect($data)->filter()->all();
                        $records->each(fn($item)=>$item->update($new_data));


                    })
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ProductsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovements::route('/'),
            'create' => Pages\CreateMovement::route('/create'),
            'edit' => Pages\EditMovement::route('/{record}/edit'),
        ];
    }
}
