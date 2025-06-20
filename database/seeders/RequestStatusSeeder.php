<?php

namespace Database\Seeders;

use App\Models\RequestStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequestStatusSeeder extends Seeder
{

    private array $data = [
        [
            'name' => 'Verifying',
            'color' => '#ada69a',
            'is_default' => true,
        ],
        [
            'name' => 'Accepted',
            'color' => '#0ecf45',
            'is_default' => false,
        ],
        [
            'name' => 'Declined',
            'color' => '#de091b',
            'is_default' => false,
        ],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data as $item) {
            RequestStatus::firstOrCreate($item);
        }
    }
}
