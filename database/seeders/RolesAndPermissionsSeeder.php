<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $collection = collect([
            'Ticket',
            'Company',
            'User',
            'Priority',
            'Status',
            'Role',
            'Permission',
        ]);

        $collection->each(function ($item, $key) {
            Permission::create(['group' => $item, 'name' => 'viewAny'.$item]);
            Permission::create(['group' => $item, 'name' => 'view'.$item]);

            switch ($item) {
                case 'Ticket':
                case 'Company':
                case 'User':
                    Permission::create(['group' => $item, 'name' => 'viewOwn'.$item]);
                    break;
            }

            Permission::create(['group' => $item, 'name' => 'update'.$item]);
            Permission::create(['group' => $item, 'name' => 'create'.$item]);
            Permission::create(['group' => $item, 'name' => 'delete'.$item]);
            Permission::create(['group' => $item, 'name' => 'forceDelete'.$item]);
            Permission::create(['group' => $item, 'name' => 'restore'.$item]);
        });

        // Create a Super-Admin Role and assign all Permissions
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        Role::create(['name' => 'manager']);
        Role::create(['name' => 'client']);

        // Give User Super-Admin Role
        $user = User::whereEmail('info@esemashko.com')->first();
        $user->assignRole('super-admin');

        $user = User::whereEmail('steve.jobs@apple.com')->first();
        $user->assignRole('client');

        $user = User::whereEmail('manager@apple.com')->first();
        $user->assignRole('client');

        $user = User::whereEmail('bill.gates@microsoft.com')->first();
        $user->assignRole('client');

        $user = User::whereEmail('larry.page@google.com')->first();
        $user->assignRole('client');
    }
}
