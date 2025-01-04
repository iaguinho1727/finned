<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProblemsResource\Pages;
use App\Filament\Resources\ProblemsResource\RelationManagers;
use App\Models\Problems;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProblemsResource extends Resource
{
    protected static ?string $model = Problems::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel='Problema';

    protected static ?string $pluralModelLabel='Problemas';

    protected static ?string $navigationGroup='Outros';

    public static function form(Form $form): Form
    {
        return ParticipantResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return ParticipantResource::table($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProblems::route('/'),
        ];
    }
}
