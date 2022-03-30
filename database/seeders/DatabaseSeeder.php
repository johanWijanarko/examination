<?php

namespace Database\Seeders;

use Prophecy\Call\Call;
use Illuminate\Database\Seeder;
use Database\Seeders\MenuSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RolesSeeder;
use Database\Seeders\AuditeeSeeder;
use Database\Seeders\PegawaiSeeder;
use Database\Seeders\AuditTypeSeeder;
use Database\Seeders\RegenciesSeeder;
use Database\Seeders\DirektoratSeeder;
use Database\Seeders\Par_aspek_Seeder;
use Database\Seeders\PermisionsSeeder;
use Database\Seeders\FaktorRisikoSeeder;
use Database\Seeders\ModelHasRolesSeeder;
use Database\Seeders\CreateAdminUserSeeder;
use Database\Seeders\IndikatorRisikoSeeder;
use Database\Seeders\PermissionTableSeeder;
use Database\Seeders\JabatanPenugasanSeeder;
use Database\Seeders\ref_program_auditSeeder;
use Database\Seeders\RoleHasPermissionsSeeder;
use Database\Seeders\ref_program_prosedurSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            // PermissionTableSeeder::class,
            // CreateAdminUserSeeder::class,
            MenuSeeder::class,
            PegawaiSeeder::class,
            UserSeeder::class,
            PermisionsSeeder::class,
            RolesSeeder::class,
            RoleHasPermissionsSeeder::class,
            ModelHasRolesSeeder::class,
            DirektoratSeeder::class,
            RegenciesSeeder::class,
            AuditeeSeeder::class,
            AuditTypeSeeder::class,
            FaktorRisikoSeeder::class,
            IndikatorRisikoSeeder::class,
            JabatanPenugasanSeeder::class,
            Par_aspek_Seeder::class,
            ref_program_auditSeeder::class,
            ref_program_prosedurSeeder::class,
            par_finding_jenis_Seeder::class
            
        ]);
        
    }
}
