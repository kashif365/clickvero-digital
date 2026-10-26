<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            PageMetaSeeder::class,
            BlogSeeder::class,
            ServiceSeeder::class,
            ServicePageContentSeeder::class,
            WebDevelopmentContentSeeder::class,
            MarketingContentSeeder::class,
        ]);

        // Placeholder people (testimonials, team) are for local UI review only.
        if (! app()->isProduction()) {
            $this->call(DemoContentSeeder::class);
        }
    }
}
