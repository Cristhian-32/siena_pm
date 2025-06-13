<?php

namespace App\Filament\Member\Resources\TicketResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeliverableRelationManagerRelationManager extends RelationManager
{
    protected static string $relationship = 'deliverables';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\SpatieMediaLibraryFileUpload::make('deliverable')
                    ->collection('deliverable')
                    ->label(__('Archivo'))
                    ->helperText(__('Selecciona un archivo para subir'))
                    ->columnSpan(1),

                Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->rows(4)
                    ->maxLength(1000),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('deliverable')
                    ->label('Archivo')
                    ->formatStateUsing(function ($state, $record) {
                        $media = $record->getFirstMedia('deliverable');
                        if (! $media) {
                            return 'Sin archivo';
                        }

                        $fileName = $media->file_name;
                        $extension = strtoupper($media->mime_type ? pathinfo($fileName, PATHINFO_EXTENSION) : '');
                        return "{$fileName} ({$extension})";
                    })
                    ->url(fn($record) => $record->getFirstMediaUrl('deliverable'))
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->icon('heroicon-o-document-text'),

            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Enviar entregable')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['status_id'] = \App\Models\DeliverableStatus::where('is_default', true)->value('id');
                        $data['user_id'] = auth()->id();
                        return $data;
                    }),

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


    protected function canCreate(): bool
    {
        return true;
    }

    protected function canDeleteAny(): bool
    {
        return false;
    }
}
