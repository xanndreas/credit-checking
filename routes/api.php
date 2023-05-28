<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'App\Http\Controllers\Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Dealer
    Route::apiResource('dealers', 'DealerApiController');

    // Products
    Route::apiResource('products', 'ProductsApiController');

    // Brands
    Route::apiResource('brands', 'BrandsApiController');

    // Year
    Route::apiResource('years', 'YearApiController');

    // Insurance
    Route::apiResource('insurances', 'InsuranceApiController');

    // Tenors
    Route::apiResource('tenors', 'TenorsApiController');

    // Auto Planner
    Route::apiResource('auto-planners', 'AutoPlannerApiController');

    // Debtor Information
    Route::apiResource('debtor-informations', 'DebtorInformationApiController');

    // Dealer Information
    Route::post('dealer-informations/media', 'DealerInformationApiController@storeMedia')->name('dealer-informations.storeMedia');
    Route::apiResource('dealer-informations', 'DealerInformationApiController');
});
