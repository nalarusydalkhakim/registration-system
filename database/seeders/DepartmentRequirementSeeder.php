<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\DepartmentRequirement;
use Illuminate\Database\Seeder;

class DepartmentRequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DepartmentRequirement::firstOrCreate(
            [
                'department_id' => 1,
                'course_id' => 1,
            ],
            [
                'minimum_grade' => 75,
            ]
        );

        DepartmentRequirement::firstOrCreate(
            [
                'department_id' => 1,
                'course_id' => 2,
            ],
            [
                'minimum_grade' => 80,
            ]
        );

        DepartmentRequirement::firstOrCreate(
            [
                'department_id' => 2,
                'course_id' => 1,
            ],
            [
                'minimum_grade' => 80,
            ]
        );

        DepartmentRequirement::firstOrCreate(
            [
                'department_id' => 2,
                'course_id' => 2,
            ],
            [
                'minimum_grade' => 75,
            ]
        );
    }
}
