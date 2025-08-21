<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserPermission;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'مسعود محمدی',
            'mobile' => '09372869339',
            'mobile_verified_at' => Carbon::now(),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'مدریک',
            'mobile' => '09129494031',
            'mobile_verified_at' => Carbon::now(),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'ماهان',
            'mobile' => '09199923151',
            'mobile_verified_at' => Carbon::now(),
            'is_admin' => true,
        ]);

        $this->call(PermissionsSeeder::class);
        $this->call(PackagesSeeder::class);


        foreach (User::all() as $user) {
            UserPermission::create([
                'user_id' => $user->id,
                'permission_id' => 1,
            ]);
        }
    }
}
