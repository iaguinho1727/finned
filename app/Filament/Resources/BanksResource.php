<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BanksResource\Pages;
use App\Filament\Resources\BanksResource\RelationManagers;
use App\Models\Banks;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BanksResource extends Resource
{
    protected static ?string $model = Banks::class;

    protected static ?string $modelLabel='Banco';
    protected static ?string $pluralModelLabel='Bancos';

    protected static ?string $navigationIcon = 'bi-bank';

    public static function form(Form $form): Form
    {
        return ParticipantResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return ParticipantResource::table($table);
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
            'index' => Pages\ListBanks::route('/'),
            'create' => Pages\CreateBanks::route('/create'),
            'edit' => Pages\EditBanks::route('/{record}/edit'),
        ];
    }
}
