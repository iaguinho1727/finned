<?php

namespace App\Filament\Resources\MovementResource\Pages;

use App\Filament\Resources\MovementResource;
use App\Models\Movement;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;

class ListMovements extends ListRecords
{
    protected static string $resource = MovementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('Criar Parcelamentos')->form([
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

                ->relationship('participant','name')->required()->label('Participant'),

                Select::make('movement_type')->options([
                    'debit'=>'Débito',
                    'credit'=>'Crédito',
                    'pix'=>'Pix',
                    'money'=>'Dinherio',
                    'transfer'=>'Transferência',
                    'other'=>'Outro'
                ])->required()->label('Tipo de Movimento')->default('pix'),

                Select::make('categories_id')->label('Categoria')
                ->createOptionForm([
                    TextInput::make('name')->label('Nome')
                ])
                ->relationship('categories','name')->preload()->searchable(),

                DatePicker::make('movement_date')->live()->required()->displayFormat('d/m/Y')->required()->label('Data da Movimentação')->native(false),

                TextInput::make('value')->required()->label('Valor')->numeric(),

                TextInput::make('parcelas')->label('Quantidade de Parcelas')->numeric()->minValue(2)->maxValue(9999)->required(),

                Select::make('dia_pagamento_parcela')->disabled(fn($get)=>str($get('movement_date'))->isEmpty())
                ->dehydrated()->required()->options(function($get){
                    $days_in_month= Carbon::parse($get('movement_date'))->daysInMonth();
                    return collect()->range(1,$days_in_month)->toArray();

                })
            ])->action(function(array $data){


                Movement::create(collect($data)->except(['parcelas','movement_date_parcelas'])->toArray());
                $movement_date=$data['movement_date'];
                $parcelas_movement_date=Carbon::parse($movement_date);
                $parcelas_movement_date->day=(int)$data['dia_pagamento_parcela']+1;
                $parcelas=(int)$data['parcelas'];
                if($parcelas_movement_date->greaterThan(Carbon::parse($movement_date)))
                {
                    $new_movement=new Movement(collect($data)->except(['parcelas','movement_date_parcelas'])->toArray());
                    $new_movement->movement_date=$parcelas_movement_date;
                    $new_movement->saveOrFail();
                    $parcelas--;

                }
                for($i=1;$i<$parcelas;$i++)
                {
                    $new_movement=new Movement(collect($data)->except(['parcelas','movement_date_parcelas'])->toArray());
                    $new_movement->movement_date=$parcelas_movement_date->addMonth();
                    $new_movement->saveOrFail();
                }

            })
        ];
    }
}
