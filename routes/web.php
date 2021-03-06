<?php

// Admin routes
Route::prefix('admin')->name('admin.')->group(function (){

    Route::get('/login', 'Admin\Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Admin\Auth\LoginController@login')->name('login.submit');
    Route::post('/logout', 'Admin\Auth\LoginController@logout')->name('logout');

    Route::middleware(['auth'])->group(function (){

        Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
        Route::resource('designations', 'Admin\DesignationController')->except(['create', 'show']);
        Route::resource('departments', 'Admin\DepartmentController')->except(['create', 'show']);

        Route::post('/admins/change-status', 'Admin\AdminController@changeStatus');
        Route::post('/admins/change-password', 'Admin\AdminController@changePassword');
        Route::resource('admins', 'Admin\AdminController')->except(['create', 'show']);

        Route::post('/employees/change-status', 'Admin\EmployeeController@changeStatus');
        Route::post('/employees/change-password', 'Admin\EmployeeController@changePassword');
        Route::resource('employees', 'Admin\EmployeeController')->except(['create', 'show']);

        Route::resource('leave-types', 'Admin\LeaveTypeController')->except(['create', 'show']);
        Route::get('/leaves/leave-reports', 'LeaveController@leaveReport')->name('report');
        Route::post('/leaves/filter-report', 'LeaveController@filterReport');
        Route::post('/leaves/change-status', 'LeaveController@changeStatus');
        Route::post('/leaves/search-leave', 'LeaveController@searchLeave');
        Route::resource('/leaves', 'LeaveController');
    });

});
// End of admin routes

// Employee routes
Route::get('/', 'Employee\Auth\LoginController@showLoginForm')->name('employee.login');
Route::prefix('employee')->name('employee.')->group(function (){

    Route::post('/login', 'Employee\Auth\LoginController@login')->name('login.submit');
    Route::post('/logout', 'Employee\Auth\LoginController@logout')->name('logout');

    Route::middleware(['auth:employee'])->group(function (){
        Route::resource('/leaves', 'LeaveController');

    });

});
// End of employee routes

