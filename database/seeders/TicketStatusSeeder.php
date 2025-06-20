<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketStatusSeeder extends Seeder
{

    private array $data = [
        [
            'name' => 'Available',
            'color' => '#008000',
            'is_default' => true,
        ],
        [
            'name' => 'Expired',
            'color' => '#ff0000',
            'is_default' => false,
        ],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data as $item) {
            TicketStatus::firstOrCreate($item);
        }
    }
}
