<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = array(
            array(
                'name' => 'Department',
                'permissions' => array(
                    array(
                        'roles' => array(
                            'Admin',
                        ),
                        'actions' => array(
                            'View',
                            'Add',
                            'Edit',
                            'Delete',
                        )
                    ),
                    array(
                        'roles' => array(
                            'Student',

                        ),
                        'actions' => array(
                            'View',
                        )
                    ),
                )
            ),
            array(
                'name' => 'Course',
                'permissions' => array(
                    array(
                        'roles' => array(
                            'Admin',
                        ),
                        'actions' => array(
                            'View',
                            'Add',
                            'Edit',
                            'Delete',
                        )
                    ),
                    array(
                        'roles' => array(
                            'Student',

                        ),
                        'actions' => array(
                            'View',
                        )
                    ),
                )
            ),
            array(
                'name' => 'Department Requirement',
                'permissions' => array(
                    array(
                        'roles' => array(
                            'Admin',
                        ),
                        'actions' => array(
                            'View',
                            'Add',
                            'Edit',
                            'Delete',
                        )
                    )
                )
            ),
            array(
                'name' => 'Registration',
                'permissions' => array(
                    array(
                        'roles' => array(
                            'Admin',
                        ),
                        'actions' => array(
                            'View',
                            'Add',
                            'Edit',
                            'Delete',
                        )
                    ),
                    array(
                        'roles' => array(
                            'Student',
                        ),
                        'actions' => array(
                            'View',
                            'Add',
                        )
                    ),
                )
            ),
        );

        foreach ($features as $feature) {
            foreach ($feature['permissions'] as $permission) {
                foreach ($permission['roles'] as $role) {
                    $roleModel = Role::where('name', $role)->where('guard_name', 'api')->first();
                    foreach ($permission['actions'] as $action) {
                        $createPermission = Permission::firstOrCreate([
                            'name' => $action . ' ' . $feature['name'],
                            'guard_name' => 'api',
                        ]);
                        $roleModel->givePermissionTo($createPermission->name);
                    }
                }
            }
        }
    }
}
