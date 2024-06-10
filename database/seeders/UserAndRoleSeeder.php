<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserAndRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create roles manager and agent
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name' => 'list_applicants']);
        Permission::create(['name' => 'list_my-applicants']);
        Permission::create(['name' => 'get_my-applicant']);
        Permission::create(['name' => 'get_applicant']);
        Permission::create(['name' => 'create_applicant']);

        $role_manager = Role::create(['name'=> 'manager'])
            ->givePermissionTo(['list_applicants', 'get_applicant', 'create_applicant']);
        $role_agent = Role::create(['name'=> 'agent'])
            ->givePermissionTo(['list_my-applicants', 'get_my-applicant']);

        $user_agent = User::create([
            'name'=> 'agent',
            'email'=> 'agent@agent.com',
            'password'=> bcrypt('password'),
            'username' => 'agent001',
        ]);

        $user_agent->assignRole('agent');

        $user_manager = User::create([
            'name' => 'manager',
            'email'=> 'manager@manager.com',
            'password'=> bcrypt('password'),
            'username' => 'manager001',
        ]);
        $user_manager->assignRole('manager');
    }
}
