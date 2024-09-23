<?php

namespace ModuleInfrastructure\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->call('module:migrate', ['module' => 'Infrastructure']);
        
        $this->call(InfrastructureBaseSeeder::class);
        $this->call(InfrastructureDataSeeder::class);
        $this->call(InfrastructureUserSeeder::class);
    }
}
