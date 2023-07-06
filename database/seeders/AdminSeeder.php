<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('00admin00'),
        ]);
        $adminRole = Role::create(['name' => 'admin']);
        $user->roles()->attach( $adminRole);
    }
}
