<?php

namespace ModuleInfrastructure\Seeders;

use Illuminate\Database\Seeder;
use Module\System\Models\SystemUser;

class InfrastructureUserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        if ($superadmin = SystemUser::firstWhere('email', env('ADMIN_EMAIL', 'monoland@dev'))) {
            $superadmin->addLicense('infrastructure-superadmin');
        }
    }
}