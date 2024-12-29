<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            [
                'email' => 'admin@mail.com'
            ],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                'status' => 'active'
            ]
        );

        $admin->syncRoles('Admin');
    }
}
