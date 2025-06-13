<?php

namespace Database\Seeders;

use App\Models\DeliverableStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliverableStatusSeeder extends Seeder
{

    private array $data = [
        [
            'name' => 'Pending',
            'color' => '#cecece',
            'is_default' => true,
        ],
        [
            'name' => 'In Review',
            'color' => '#ff7f00',
            'is_default' => false,
        ],
        [
            'name' => 'Done',
            'color' => '#008000',
            'is_default' => false,
        ],
        [
            'name' => 'Refused',
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
            DeliverableStatus::firstOrCreate($item);
        }
    }
}
