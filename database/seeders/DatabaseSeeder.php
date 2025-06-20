<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(ProjectStatusSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(TicketStatusSeeder::class);
        $this->call(TicketTypeSeeder::class);
        $this->call(DeliverableStatusSeeder::class);
        Storage::disk('public')->deleteDirectory('media'); // Borra todas las imágenes de Spatie

    }
}
