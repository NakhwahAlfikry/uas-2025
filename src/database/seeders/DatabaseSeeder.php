<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
      
        Role::firstOrCreate(['name' => 'super_admin']);
        $allPermissions = Permission::all();

        
        $user1 = User::factory()->create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@admin.com',
        ]);
        $user1->assignRole('super_admin');

        //role petugas gudang
        $gudangRole = Role::firstOrCreate(['name' => 'Petugas_Gudang']);

        $gudangPermissions = $allPermissions->filter(function ($perm) {
        return (
            str_contains($perm->name, 'category') ||
            str_contains($perm->name, 'item') ||
            str_contains($perm->name, 'transaction')
        ) && (
            str_contains($perm->name, 'create') ||
            str_contains($perm->name, 'view') ||
            str_contains($perm->name, 'update') ||
            str_contains($perm->name, 'delete')
        );
        });

       
        $gudangRole->syncPermissions($gudangPermissions);


        $gudang = User::firstOrCreate(
            ['email' => 'petugas@petugas.com'],
            ['name' => 'Petugas', 'password' => bcrypt('password')]
        );
        $gudang->assignRole($gudangRole);


        $this->call([
            CategorySeeder::class,
            ItemSeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
