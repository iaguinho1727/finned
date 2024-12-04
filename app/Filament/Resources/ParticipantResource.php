<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParticipantResource\Pages;
use App\Filament\Resources\ParticipantResource\RelationManagers;
use App\Filament\Resources\ParticipantResource\RelationManagers\MovementsRelationManager;
use App\Models\Participant;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParticipantResource extends Resource
{
    protected static ?string $model = Participant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Nome')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextInputColumn::make('name')->label('Nome')->searchable()->columnSpanFull(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                ViewAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function getRelations() : array
    {
        return [
            MovementsRelationManager::class
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageParticipants::route('/'),
        ];
    }
}
