<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{

    private array $data = [
        [
            'name' => 'Proyecto de Investigación GRUPO 1',
            'description' => 'Proyecto de Investigación de Jornada Cientifica 2025 UPEU JULIACA 2025',
            'ticket_prefix' => 'G01',
            'user_id' => 1,
            'status_id' => 1,
        ]
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data as $item) {
            Project::firstOrCreate($item);
        }
    }
}
