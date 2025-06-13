<?php

namespace App\Filament\Resources\DeliverableStatusResource\Pages;

use App\Filament\Resources\DeliverableStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeliverableStatuses extends ListRecords
{
    protected static string $resource = DeliverableStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
