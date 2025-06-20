<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Models\TicketStatus;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Carbon;

class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate($record, array $data): \Illuminate\Database\Eloquent\Model
    {
        if (!empty($data['date_end'])) {
            $dateEnd = Carbon::parse($data['date_end']);

            if ($dateEnd->gt(now())) {
                // Fecha en el futuro → Available
                $statusId = TicketStatus::where('name', 'Available')->value('id');
            } else {
                // Fecha ya pasada o igual a hoy → Expired
                $statusId = TicketStatus::where('name', 'Expired')->value('id');
            }

            if ($statusId) {
                $data['status_id'] = $statusId;
            }
        }

        $record->update($data);

        return $record;
    }
}
