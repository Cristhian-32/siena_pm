<?php

namespace App\Filament\Member\Resources;

use App\Filament\Member\Resources\TicketResource\Pages;
use App\Filament\Member\Resources\TicketResource\RelationManagers;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Models\TicketType;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Select::make('project_id')
                                    ->label(__('Project'))
                                    ->searchable()
                                    ->options(fn() => Project::all()->pluck('name', 'id')->toArray())
                                    ->required(),
                                Forms\Components\Grid::make()
                                    ->columns(12)
                                    ->columnSpan(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('code')
                                            ->label(__('Ticket code'))
                                            ->visible(fn($livewire) => !($livewire instanceof CreateRecord))
                                            ->columnSpan(2)
                                            ->disabled(),

                                        Forms\Components\TextInput::make('name')
                                            ->label(__('Ticket name'))
                                            ->required()
                                            ->columnSpan(
                                                fn($livewire) => !($livewire instanceof CreateRecord) ? 10 : 12
                                            )
                                            ->maxLength(255),
                                    ]),
                                Forms\Components\Select::make('owner_id')
                                    ->label(__('Ticket owner'))
                                    ->searchable()
                                    ->options(fn() => User::all()->pluck('name', 'id')->toArray())
                                    ->default(fn() => auth()->user()->id)
                                    ->required(),
                                Forms\Components\Select::make('responsible_id')
                                    ->label(__('Ticket responsible'))
                                    ->searchable()
                                    ->options(fn() => User::all()->pluck('name', 'id')->toArray()),

                                Forms\Components\Grid::make()
                                    ->columns(3)
                                    ->columnSpan(2)
                                    ->schema([
                                        Forms\Components\Select::make('status_id')
                                            ->label(__('Ticket status'))
                                            ->searchable()
                                            ->options(fn() => TicketStatus::all()->pluck('name', 'id')->toArray())
                                            ->default(fn() => TicketStatus::where('is_default', true)->first()?->id)
                                            ->required(),

                                        Forms\Components\Select::make('type_id')
                                            ->label(__('Ticket type'))
                                            ->searchable()
                                            ->options(fn() => TicketType::all()->pluck('name', 'id')->toArray())
                                            ->default(fn() => TicketType::where('is_default', true)->first()?->id)
                                            ->required(),

                                    ]),

                            ]),
                        Forms\Components\RichEditor::make('content')
                            ->label(__('Ticket content'))
                            ->required()
                            ->columnSpan(2),
                    ]),
            ]);
    }

    public static function tableColumns(bool $withProject = true): array
    {
        $columns = [];
        if ($withProject) {
            $columns[] = Tables\Columns\TextColumn::make('project.name')
                ->label(__('Project'))
                ->sortable()
                ->searchable();
        }
        $columns = array_merge($columns, [
            Tables\Columns\TextColumn::make('name')
                ->label(__('Ticket name'))
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('owner.name')
                ->label(__('Owner'))
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('responsible.name')
                ->label(__('Responsible'))
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('status.name')
                ->label(__('Status'))
                ->formatStateUsing(fn($record) => new HtmlString('
                            <div class="flex items-center gap-2 mt-1">
                                <span class="filament-tables-color-column relative flex h-6 w-6 rounded-md"
                                    style="background-color: ' . $record->status->color . '"></span>
                                <span>' . $record->status->name . '</span>
                            </div>
                        '))
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('type.name')
                ->label(__('Type'))

                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('created_at')
                ->label(__('Created at'))
                ->dateTime()
                ->sortable()
                ->searchable(),
        ]);
        return $columns;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::tableColumns())
            ->filters([
                Tables\Filters\SelectFilter::make('project_id')
                    ->label(__('Project'))
                    ->multiple()
                    ->options(fn() => Project::where('user_id', auth()->user()->id)
                        ->orWhereHas('users', function ($query) {
                            return $query->where('users.id', auth()->user()->id);
                        })->pluck('name', 'id')->toArray()),

                Tables\Filters\SelectFilter::make('owner_id')
                    ->label(__('Owner'))
                    ->multiple()
                    ->options(fn() => User::all()->pluck('name', 'id')->toArray()),

                Tables\Filters\SelectFilter::make('responsible_id')
                    ->label(__('Responsible'))
                    ->multiple()
                    ->options(fn() => User::all()->pluck('name', 'id')->toArray()),

                Tables\Filters\SelectFilter::make('status_id')
                    ->label(__('Status'))
                    ->multiple()
                    ->options(fn() => TicketStatus::all()->pluck('name', 'id')->toArray()),

                Tables\Filters\SelectFilter::make('type_id')
                    ->label(__('Type'))
                    ->multiple()
                    ->options(fn() => TicketType::all()->pluck('name', 'id')->toArray()),

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
            RelationManagers\DeliverableRelationManagerRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
