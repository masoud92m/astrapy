<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'users.edit.permissions' => 'ویرایش دسترسی کاربر',
        ];
        foreach ($permissions as $name => $label) {
            Permission::create([
                'name' => $name,
                'label' => $label,
            ]);
        }
    }
}
