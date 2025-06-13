<?php

namespace App\Filament\Resources\DeliverableStatusResource\Pages;

use App\Filament\Resources\DeliverableStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeliverableStatus extends EditRecord
{
    protected static string $resource = DeliverableStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
