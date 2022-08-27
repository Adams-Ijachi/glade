<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create company', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete company', 'guard_name' => 'api']);
        Permission::create(['name' => 'update company', 'guard_name' => 'api']);
        Permission::create(['name' => 'get company', 'guard_name' => 'api']);


        Permission::create(['name' => 'create employee', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete employee', 'guard_name' => 'api']);
        Permission::create(['name' => 'update employee', 'guard_name' => 'api']);
        Permission::create(['name' => 'get employee', 'guard_name' => 'api']);

        Permission::create(['name' => 'create admin', 'guard_name'=>'api']);
        Permission::create(['name' => 'delete admin', 'guard_name'=>'api']);
        Permission::create(['name' => 'update admin', 'guard_name'=>'api']);
        Permission::create(['name' => 'get admin', 'guard_name'=>'api']);

        $employee = Role::create(['name' => 'employee','guard_name' => 'api']);
        $employee->givePermissionTo(['get employee', 'update employee', 'get company']);

        $company_role = Role::create(['name' => 'company', 'guard_name' => 'api']);
        $company_role->givePermissionTo(['create employee', 'delete employee', 'update employee', 'get employee']);

        $admin_role = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $admin_role->givePermissionTo(['create company', 'create employee']);

        $super_admin_role = Role::create(['name' => 'super-admin', 'guard_name' => 'api']);
        $super_admin_role->givePermissionTo(Permission::all());
    }
}
