<?php

namespace Database\Seeders;

use App\Models\Admin;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superRole = Role::create(['guard_name' => 'admin', 'name' => 'Super-Admin']);

        DB::table('admins')->delete();

        $superAdmin = Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@digibank.com',
            'password' => Hash::make(12345678),
        ]);

        $superAdmin->assignRole($superRole);
    }
}
