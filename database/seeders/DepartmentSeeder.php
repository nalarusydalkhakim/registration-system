<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::firstOrCreate([
            'name' => 'Departemen Teknologi Informasi',
        ], [
            'quota' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Department::firstOrCreate([
            'name' => 'Departemen Teknik Mesin',
        ], [
            'quota' => 8,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Department::firstOrCreate([
            'name' => 'Departemen Sains',
        ], [
            'quota' => 15,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
