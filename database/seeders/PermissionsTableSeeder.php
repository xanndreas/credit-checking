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
                'title' => 'input_parameter_access',
            ],
            [
                'id'    => 18,
                'title' => 'respondent_access',
            ],
            [
                'id'    => 19,
                'title' => 'dealer_create',
            ],
            [
                'id'    => 20,
                'title' => 'dealer_edit',
            ],
            [
                'id'    => 21,
                'title' => 'dealer_show',
            ],
            [
                'id'    => 22,
                'title' => 'dealer_delete',
            ],
            [
                'id'    => 23,
                'title' => 'dealer_access',
            ],
            [
                'id'    => 24,
                'title' => 'product_create',
            ],
            [
                'id'    => 25,
                'title' => 'product_edit',
            ],
            [
                'id'    => 26,
                'title' => 'product_show',
            ],
            [
                'id'    => 27,
                'title' => 'product_delete',
            ],
            [
                'id'    => 28,
                'title' => 'product_access',
            ],
            [
                'id'    => 29,
                'title' => 'brand_create',
            ],
            [
                'id'    => 30,
                'title' => 'brand_edit',
            ],
            [
                'id'    => 31,
                'title' => 'brand_show',
            ],
            [
                'id'    => 32,
                'title' => 'brand_delete',
            ],
            [
                'id'    => 33,
                'title' => 'brand_access',
            ],
            [
                'id'    => 34,
                'title' => 'year_create',
            ],
            [
                'id'    => 35,
                'title' => 'year_edit',
            ],
            [
                'id'    => 36,
                'title' => 'year_show',
            ],
            [
                'id'    => 37,
                'title' => 'year_delete',
            ],
            [
                'id'    => 38,
                'title' => 'year_access',
            ],
            [
                'id'    => 39,
                'title' => 'insurance_create',
            ],
            [
                'id'    => 40,
                'title' => 'insurance_edit',
            ],
            [
                'id'    => 41,
                'title' => 'insurance_show',
            ],
            [
                'id'    => 42,
                'title' => 'insurance_delete',
            ],
            [
                'id'    => 43,
                'title' => 'insurance_access',
            ],
            [
                'id'    => 44,
                'title' => 'tenor_create',
            ],
            [
                'id'    => 45,
                'title' => 'tenor_edit',
            ],
            [
                'id'    => 46,
                'title' => 'tenor_show',
            ],
            [
                'id'    => 47,
                'title' => 'tenor_delete',
            ],
            [
                'id'    => 48,
                'title' => 'tenor_access',
            ],
            [
                'id'    => 49,
                'title' => 'auto_planner_create',
            ],
            [
                'id'    => 50,
                'title' => 'auto_planner_edit',
            ],
            [
                'id'    => 51,
                'title' => 'auto_planner_show',
            ],
            [
                'id'    => 52,
                'title' => 'auto_planner_delete',
            ],
            [
                'id'    => 53,
                'title' => 'auto_planner_access',
            ],
            [
                'id'    => 54,
                'title' => 'debtor_information_create',
            ],
            [
                'id'    => 55,
                'title' => 'debtor_information_edit',
            ],
            [
                'id'    => 56,
                'title' => 'debtor_information_show',
            ],
            [
                'id'    => 57,
                'title' => 'debtor_information_delete',
            ],
            [
                'id'    => 58,
                'title' => 'debtor_information_access',
            ],
            [
                'id'    => 59,
                'title' => 'dealer_information_create',
            ],
            [
                'id'    => 60,
                'title' => 'dealer_information_edit',
            ],
            [
                'id'    => 61,
                'title' => 'dealer_information_show',
            ],
            [
                'id'    => 62,
                'title' => 'dealer_information_delete',
            ],
            [
                'id'    => 63,
                'title' => 'dealer_information_access',
            ],
            [
                'id'    => 64,
                'title' => 'profile_password_edit',
            ],
            [
                'id'    => 65,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 66,
                'title' => 'dashboard_access',
            ],
            [
                'id'    => 67,
                'title' => 'credit_checking_access',
            ],
            [
                'id'    => 68,
                'title' => 'credit_check_access',
            ],
            [
                'id'    => 69,
                'title' => 'credit_check_create',
            ],
            [
                'id'    => 70,
                'title' => 'credit_check_show',
            ],
            [
                'id'    => 71,
                'title' => 'credit_check_access_super',
            ],
            [
                'id'    => 72,
                'title' => 'tenant_marketing_head',
            ],
            [
                'id'    => 73,
                'title' => 'tenant_area_manager',
            ],
            [
                'id'    => 74,
                'title' => 'tenant_branch_manager',
            ],
            [
                'id'    => 75,
                'title' => 'tenant_auto_planner',
            ],
            [
                'id'    => 76,
                'title' => 'team_access',
            ],
            [
                'id'    => 77,
                'title' => 'team_create',
            ],
            [
                'id'    => 78,
                'title' => 'team_edit',
            ],
            [
                'id'    => 79,
                'title' => 'team_show',
            ],
            [
                'id'    => 80,
                'title' => 'team_delete',
            ],
            [
                'id'    => 81,
                'title' => 'approval_delete',
            ],
            [
                'id'    => 82,
                'title' => 'approval_edit',
            ],
            [
                'id'    => 83,
                'title' => 'approval_create',
            ],
            [
                'id'    => 84,
                'title' => 'approval_show',
            ],
            [
                'id'    => 85,
                'title' => 'approval_access',
            ],
            [
                'id'    => 90,
                'title' => 'survey_delete',
            ],
            [
                'id'    => 86,
                'title' => 'survey_edit',
            ],
            [
                'id'    => 87,
                'title' => 'survey_create',
            ],
            [
                'id'    => 88,
                'title' => 'survey_show',
            ],
            [
                'id'    => 89,
                'title' => 'survey_access',
            ],
            [
                'id'    => 91,
                'title' => 'survey_assign_surveyors',
            ],
            [
                'id'    => 92,
                'title' => 'approval_approve_request',
            ],
            [
                'id'    => 93,
                'title' => 'survey_surveyors',
            ],
            [
                'id'    => 94,
                'title' => 'survey_report_create',
            ],
            [
                'id'    => 95,
                'title' => 'survey_report_show',
            ],
        ];

        Permission::insert($permissions);
    }
}
