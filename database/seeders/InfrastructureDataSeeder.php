<?php

namespace ModuleInfrastructure\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Module\Infrastructure\Imports\DataImport;

class InfrastructureDataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $path = base_path(
            'modules' . DIRECTORY_SEPARATOR .
                'infrastructure' . DIRECTORY_SEPARATOR .
                'database' . DIRECTORY_SEPARATOR .
                'masters' . DIRECTORY_SEPARATOR .
                'data-seeder.xlsx'
        );

        if (File::exists($path)) {
            Excel::import(new DataImport($this->command), $path);
        }
    }
}
