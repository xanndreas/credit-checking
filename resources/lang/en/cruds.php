<?php

return [
    'userManagement' => [
        'title'          => 'User management',
        'title_singular' => 'User management',
    ],
    'permission' => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'role' => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'title'              => 'Title',
            'title_helper'       => ' ',
            'permissions'        => 'Permissions',
            'permissions_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'user' => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'name'                     => 'Name',
            'name_helper'              => ' ',
            'email'                    => 'Email',
            'email_helper'             => ' ',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => ' ',
            'password'                 => 'Password',
            'password_helper'          => ' ',
            'roles'                    => 'Roles',
            'roles_helper'             => ' ',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => ' ',
            'created_at'               => 'Created at',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
            'approved'                 => 'Approved',
            'approved_helper'          => ' ',
        ],
    ],
    'inputParameter' => [
        'title'          => 'Input Parameters',
        'title_singular' => 'Input Parameter',
    ],
    'respondent' => [
        'title'          => 'Respondent',
        'title_singular' => 'Respondent',
    ],
    'dealer' => [
        'title'          => 'Dealer',
        'title_singular' => 'Dealer',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'aliases'           => 'Aliases',
            'aliases_helper'    => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'product' => [
        'title'          => 'Products',
        'title_singular' => 'Product',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
            'aliases'           => 'Aliases',
            'aliases_helper'    => ' ',
        ],
    ],
    'brand' => [
        'title'          => 'Brands',
        'title_singular' => 'Brand',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'aliases'           => 'Aliases',
            'aliases_helper'    => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'year' => [
        'title'          => 'Year',
        'title_singular' => 'Year',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'insurance' => [
        'title'          => 'Insurance',
        'title_singular' => 'Insurance',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'slug'              => 'Slug',
            'slug_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'tenor' => [
        'title'          => 'Tenors',
        'title_singular' => 'Tenor',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'year'              => 'Year',
            'year_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'autoPlanner' => [
        'title'          => 'Auto Planner',
        'title_singular' => 'Auto Planner',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'auto_planner_name'        => 'Auto Planner Name',
            'auto_planner_name_helper' => ' ',
            'type'                     => 'Type',
            'type_helper'              => ' ',
            'created_at'               => 'Created at',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
        ],
    ],
    'debtorInformation' => [
        'title'          => 'Debtor Information',
        'title_singular' => 'Debtor Information',
        'fields'         => [
            'id'                              => 'ID',
            'id_helper'                       => ' ',
            'debtor_name'                     => 'Debtor Name',
            'debtor_name_helper'              => ' ',
            'id_type'                         => 'Id Type',
            'id_type_helper'                  => ' ',
            'id_number'                       => 'Id Number',
            'id_number_helper'                => ' ',
            'partner_name'                    => 'Partner Name',
            'partner_name_helper'             => ' ',
            'guarantor_id_number'             => 'Guarantor Id Number',
            'guarantor_id_number_helper'      => ' ',
            'guarantor_name'                  => 'Guarantor Name',
            'guarantor_name_helper'           => ' ',
            'created_at'                      => 'Created at',
            'created_at_helper'               => ' ',
            'updated_at'                      => 'Updated at',
            'updated_at_helper'               => ' ',
            'deleted_at'                      => 'Deleted at',
            'deleted_at_helper'               => ' ',
            'auto_planner_information'        => 'Auto Planner Information',
            'auto_planner_information_helper' => ' ',
        ],
    ],
    'dealerInformation' => [
        'title'          => 'Dealer Information',
        'title_singular' => 'Dealer Information',
        'fields'         => [
            'id'                        => 'ID',
            'id_helper'                 => ' ',
            'dealer'                    => 'Dealer',
            'dealer_helper'             => ' ',
            'sales_name'                => 'Sales Name',
            'sales_name_helper'         => ' ',
            'product'                   => 'Product',
            'product_helper'            => ' ',
            'brand'                     => 'Brand',
            'brand_helper'              => ' ',
            'models'                    => 'Models',
            'models_helper'             => ' ',
            'number_of_units'           => 'Number Of Units',
            'number_of_units_helper'    => ' ',
            'otr'                       => 'Otr',
            'otr_helper'                => ' ',
            'debt_principal'            => 'Debt Principal',
            'debt_principal_helper'     => ' ',
            'insurance'                 => 'Insurance',
            'insurance_helper'          => ' ',
            'down_payment'              => 'Down Payment',
            'down_payment_helper'       => ' ',
            'tenors'                    => 'Tenors',
            'tenors_helper'             => ' ',
            'addm_addb'                 => 'ADDM / ADDB',
            'addm_addb_helper'          => ' ',
            'effective_rates'           => 'Effective Rates',
            'effective_rates_helper'    => ' ',
            'debtor_phone'              => 'Debtor Phone',
            'debtor_phone_helper'       => ' ',
            'id_photos'                 => 'ID Photos',
            'id_photos_helper'          => ' ',
            'remarks'                   => 'Remarks',
            'remarks_helper'            => ' ',
            'debtor_information'        => 'Debtor Information',
            'debtor_information_helper' => ' ',
            'created_at'                => 'Created at',
            'created_at_helper'         => ' ',
            'updated_at'                => 'Updated at',
            'updated_at_helper'         => ' ',
            'deleted_at'                => 'Deleted at',
            'deleted_at_helper'         => ' ',
        ],
    ],

];
