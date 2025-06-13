<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectStatusResource\Pages;
use App\Filament\Resources\ProjectStatusResource\RelationManagers;
use App\Models\ProjectStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectStatusResource extends Resource
{
    protected static ?string $model = ProjectStatus::class;

    protected static ?string $navigationIcon = 'grommet-status-unknown';

    public static function getNavigationLabel(): string
    {
        return __('Project Status');
    }

    public static function getPluralLabel(): ?string
    {
        return static::getNavigationLabel();
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Referential');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('Nombre de Estado de Proyecto'))
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\ColorPicker::make('color')
                                    ->label(__('Color de Estado'))
                                    ->required(),

                                Forms\Components\Checkbox::make('is_default')
                                    ->label(__('Estado Por Defecto'))
                                    ->helperText(
                                        __('Si se marca, este estado se aplicará automáticamente a los nuevos proyectos.')
                                    ),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ColorColumn::make('color')
                    ->label(__('Status color'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Status name'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_default')
                    ->label(__('Default status'))
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListProjectStatuses::route('/'),
            'create' => Pages\CreateProjectStatus::route('/create'),
            'edit' => Pages\EditProjectStatus::route('/{record}/edit'),
        ];
    }
}
