<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::resource('permissions', 'PermissionsController');

    Route::resource('roles', 'RolesController');

    Route::resource('users', 'UsersController');

    Route::resource('dealers', 'DealerController');

    Route::resource('products', 'ProductsController');

    Route::resource('brands', 'BrandsController');

    Route::resource('years', 'YearController');

    Route::resource('insurances', 'InsuranceController');

    Route::resource('tenors', 'TenorsController');

    Route::resource('teams', 'TeamsController');

    Route::resource('credit-checks', 'CreditChecksController');

    Route::resource('surveys', 'SurveysController');

    Route::resource('approvals', 'ApprovalsController');

    Route::post('approvals/approve', 'ApprovalsController@approve')->name('approvals.approve');

    Route::post('users/tenant-parents', 'UsersController@getTenantParents')->name('users.tenantParents');

    Route::post('credit-checks/download', 'CreditChecksController@download')->name('credit-checks.download');

    Route::post('credit-checks/dealer-informations/media', 'CreditChecksController@storeMedia')->name('credit-checks.dealer-informations.storeMedia');
//    Route::post('dealer-informations/ckmedia', 'DealerInformationController@storeCKEditorImages')->name('dealer-informations.storeCKEditorImages');
//    Route::resource('dealer-informations', 'DealerInformationController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'App\Http\Controllers\Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
