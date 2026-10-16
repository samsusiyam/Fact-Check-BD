<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'view_any_post',
            'view_post',
            'create_post',
            'update_own_post',
            'update_any_post',
            'delete_own_post',
            'delete_any_post',
            'publish_post',
            'manage_settings',
            'manage_users',
            'manage_media',
            'manage_pages',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
        }

        // Create Roles
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $editor = Role::firstOrCreate(['name' => 'Editor', 'guard_name' => 'web']);
        $author = Role::firstOrCreate(['name' => 'Author', 'guard_name' => 'web']);
        $contributor = Role::firstOrCreate(['name' => 'Contributor', 'guard_name' => 'web']);

        // Assign Permissions
        $superAdmin->givePermissionTo(Permission::all());
        
        $editor->givePermissionTo([
            'view_any_post',
            'view_post',
            'create_post',
            'update_own_post',
            'update_any_post',
            'delete_own_post',
            'delete_any_post',
            'publish_post',
            'manage_media',
            'manage_pages',
        ]);

        $author->givePermissionTo([
            'view_any_post',
            'view_post',
            'create_post',
            'update_own_post',
            'delete_own_post',
            'manage_media',
        ]);

        $contributor->givePermissionTo([
            'view_any_post',
            'view_post',
            'create_post',
            'update_own_post',
        ]);

        // Create Default Users with clear role demarcation
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@factcheckbd.org'],
            [
                'name' => 'Chief Editor',
                'password' => Hash::make('Admin@FactCheck2026!'),
                'email_verified_at' => now(),
            ]
        );
        $adminUser->assignRole($superAdmin);

        $editorUser = User::firstOrCreate(
            ['email' => 'editor@factcheckbd.org'],
            [
                'name' => 'Senior Fact-Check Editor',
                'password' => Hash::make('Editor@FactCheck2026!'),
                'email_verified_at' => now(),
            ]
        );
        $editorUser->assignRole($editor);

        $authorUser = User::firstOrCreate(
            ['email' => 'investigator@factcheckbd.org'],
            [
                'name' => 'Fact-Check Investigator',
                'password' => Hash::make('Author@FactCheck2026!'),
                'email_verified_at' => now(),
            ]
        );
        $authorUser->assignRole($author);
    }
}
