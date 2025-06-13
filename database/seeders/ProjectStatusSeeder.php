<?php

namespace Database\Seeders;

use App\Models\ProjectStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProjectStatus::create([
            'name' => 'initiated',
            'is_default' => true,
        ]);

        ProjectStatus::create([
            'name' => 'in progress',
            'color' => '#ff7f00',
            'is_default' => false,
        ]);

        ProjectStatus::create([
            'name' => 'done',
            'color' => '#008000',
            'is_default' => false,
        ]);

        ProjectStatus::create([
            'name' => 'suspended',
            'color' => '#ff0000',
            'is_default' => false,
        ]);
    }
}
