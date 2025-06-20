<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;

class ExpireTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-tickets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredStatusId = 2; // o el ID que corresponda a "expired"

        Ticket::where('status_id', '!=', $expiredStatusId)
            ->whereNotNull('date_end')
            ->where('date_end', '<', now())
            ->update(['status_id' => $expiredStatusId]);

        $this->info('Tickets expirados actualizados correctamente.');
    }
}
