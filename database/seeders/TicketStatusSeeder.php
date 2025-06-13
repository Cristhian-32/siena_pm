<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketStatusSeeder extends Seeder
{

    private array $data = [
        [
            'name' => 'Todo',
            'color' => '#cecece',
            'is_default' => true,
        ],
        [
            'name' => 'In progress',
            'color' => '#ff7f00',
            'is_default' => false,
        ],
        [
            'name' => 'Done',
            'color' => '#008000',
            'is_default' => false,
        ],
        [
            'name' => 'Archived',
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
