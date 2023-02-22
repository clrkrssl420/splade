<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'lead_create',
            ],
            [
                'id'    => 18,
                'title' => 'lead_edit',
            ],
            [
                'id'    => 19,
                'title' => 'lead_delete',
            ],
            [
                'id'    => 20,
                'title' => 'lead_access',
            ],
            [
                'id'    => 21,
                'title' => 'my_lead_access',
            ],
            [
                'id'    => 22,
                'title' => 'prospect_create',
            ],
            [
                'id'    => 23,
                'title' => 'prospect_edit',
            ],
            [
                'id'    => 24,
                'title' => 'prospect_show',
            ],
            [
                'id'    => 25,
                'title' => 'prospect_delete',
            ],
            [
                'id'    => 26,
                'title' => 'prospect_access',
            ],
            [
                'id'    => 27,
                'title' => 'project_create',
            ],
            [
                'id'    => 28,
                'title' => 'project_edit',
            ],
            [
                'id'    => 29,
                'title' => 'project_show',
            ],
            [
                'id'    => 30,
                'title' => 'project_delete',
            ],
            [
                'id'    => 31,
                'title' => 'project_access',
            ],
            [
                'id'    => 32,
                'title' => 'setting_access',
            ],
            [
                'id'    => 33,
                'title' => 'lead_setting_access',
            ],
            [
                'id'    => 34,
                'title' => 'project_setting_access',
            ],
            [
                'id'    => 35,
                'title' => 'project_type_create',
            ],
            [
                'id'    => 36,
                'title' => 'project_type_edit',
            ],
            [
                'id'    => 37,
                'title' => 'project_type_show',
            ],
            [
                'id'    => 38,
                'title' => 'project_type_delete',
            ],
            [
                'id'    => 39,
                'title' => 'project_type_access',
            ],
            [
                'id'    => 40,
                'title' => 'lead_status_create',
            ],
            [
                'id'    => 41,
                'title' => 'lead_status_edit',
            ],
            [
                'id'    => 42,
                'title' => 'lead_status_show',
            ],
            [
                'id'    => 43,
                'title' => 'lead_status_delete',
            ],
            [
                'id'    => 44,
                'title' => 'lead_status_access',
            ],
            [
                'id'    => 45,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
