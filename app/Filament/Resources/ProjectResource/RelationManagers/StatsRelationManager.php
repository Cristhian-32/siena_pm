<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StatsRelationManager extends RelationManager
{
    protected static string $relationship = 'stat';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('budget_init')
                    ->required()
                    ->numeric()
                    ->live(),

                Forms\Components\TextInput::make('budget_current')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->afterStateHydrated(function ($set, $get, $state) {
                        // Solo establecer si está vacío
                        if (is_null($state)) {
                            $set('budget_current', $get('budget_init'));
                        }
                    }),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('stats')
            ->columns([
                Tables\Columns\TextColumn::make('project_id'),
                Tables\Columns\TextColumn::make('budget_init'),
                Tables\Columns\TextColumn::make('budget_current'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
