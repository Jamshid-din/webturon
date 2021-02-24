<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['guest']], function () {
    // Guest routs
    Route::get('/',     'HomeViewController@index')->name('home');
    Route::get('/home', 'HomeViewController@index')->name('home');
    Route::post('/home-store', 'HomeViewController@store')->name('store-message');
    
    Route::get('/docs', 'DocumentController@index');
    Route::get('/docs/fetch_data', 'DocumentController@fetchData');
    Route::get('/docs/fetch_child/{id}', 'DocumentController@fetchChild');
    Route::get('/download-docs/{id}', 'DocumentController@download')->name('download-docs');
    
    Route::get('/ip_phones', 'IpPhoneController@index');
    Route::get('/ip_phones/fetch_data', 'IpPhoneController@fetchData');
    
    Route::get('/staff', 'StaffController@index');
    Route::get('/staff/fetch_data', 'StaffController@fetchData');
    Route::get('/download-personal/{id}', 'StaffController@download')->name('download-docs');
    
    Route::get('/soft-guest', 'SoftController@indexGuest');
	Route::get('/soft/fetch_data/{id}', 'SoftController@fetchData');
	Route::get('/soft-download/{id}', 'SoftController@download');
	
	Route::get('/news-guest','NewsController@guestIndex');
	Route::get('/news-fetch-post/{id}','NewsController@show');

});



Auth::routes([
	'register' => false, // Registration Routes...
	'reset' => false, // Password Reset Routes...
	'verify' => false, // Email Verification Routes...
  ]);

Route::resource('/home', 'HomeController')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

	// User Roles Control
	Route::resource('/user-roles', 'UserRolesController');
	
	//  For Document Control
	Route::any('/admin-docs-arch', 'AdminDocsController@archIndex')->name('admin-docs-archive');
	Route::prefix('/admin-docs-arch')->group(function(){
		Route::post('/store', 'AdminDocsController@archStore')->name('store-arch-doc');
		Route::post('/update', 'AdminDocsController@archUpdate')->name('update-arch-doc');
		Route::delete('/{id}', 'AdminDocsController@archDelete');
		Route::get('/{id}', 'AdminDocsController@archGetOld');
	});
	Route::any('/admin-docs-personal', 'AdminDocsController@personalIndex')->name('admin-docs-personal');
	Route::prefix('/admin-docs-personal')->group(function(){
		Route::post('/store', 'AdminDocsController@personalStore')->name('store-personal-doc');
		Route::post('/update', 'AdminDocsController@personalUpdate')->name('update-personal-doc');
		Route::delete('/{id}', 'AdminDocsController@personalDelete');
		Route::get('/{id}', 'AdminDocsController@personalGetOld');
	});

	// For Menu Control

	// Archive Menu
	Route::any('/admin-menu-archive', 'AdminMenuController@archIndex')->name('admin-menu-archive');
	Route::prefix('/admin-menu-archive')->group(function(){
		Route::post('/store', 'AdminMenuController@archMenuStore')->name('store-arch-menu');
		Route::post('/update', 'AdminMenuController@archMenuUpdate')->name('update-arch-menu');
		Route::delete('/{id}', 'AdminMenuController@archMenuDelete');
		Route::get('/{id}', 'AdminMenuController@archMenuOld');
	});
	Route::any('/admin-menu-archive-sub', 'AdminMenuController@archSubIndex')->name('admin-menu-archive-sub');
	Route::prefix('/admin-menu-archive-sub')->group(function(){
		Route::post('/store', 'AdminMenuController@archSubStore')->name('store-arch-sub-menu');
		Route::post('/update', 'AdminMenuController@archSubUpdate')->name('update-arch-sub-menu');
		Route::delete('/{id}', 'AdminMenuController@archSubDelete');
		Route::get('/{id}', 'AdminMenuController@archSubMenuOld');
		Route::get('/fetch-sub/{id}', 'AdminMenuController@getArchSubMenu');
	});

	// Personal Menu
	Route::any('/admin-menu-personal', 'AdminMenuController@personalIndex')->name('admin-menu-personal');
	Route::prefix('/admin-menu-personal')->group(function(){
		Route::post('/store', 'AdminMenuController@personalStore')->name('store-personal-menu');
		Route::post('/update', 'AdminMenuController@personalUpdate')->name('update-personal-menu');
		Route::delete('/{id}', 'AdminMenuController@personalDelete');
		Route::get('/{id}', 'AdminMenuController@personalMenuOld');
	});
	Route::any('/admin-menu-personal-sub', 'AdminMenuController@personalSubIndex')->name('admin-menu-personal-sub');
	Route::prefix('/admin-menu-personal-sub')->group(function(){
		Route::post('/store', 'AdminMenuController@personalSubStore')->name('store-personal-sub-menu');
		Route::post('/update', 'AdminMenuController@personalSubUpdate')->name('update-personal-sub-menu');
		Route::delete('/{id}', 'AdminMenuController@personalSubDelete');
		Route::get('/{id}', 'AdminMenuController@personalSubMenuOld');
		Route::get('/fetch-sub/{id}', 'AdminMenuController@getPersonalSubMenu');
	});

	// Soft Menu
	Route::any('/admin-menu-soft', 'AdminMenuController@softIndex')->name('admin-menu-soft');
	Route::prefix('/admin-menu-soft')->group(function(){
		Route::post('/store', 'AdminMenuController@softStore')->name('admin-menu-soft.store');
		Route::put('/{id}', 'AdminMenuController@softUpdate')->name('admin-menu-soft.update');
		Route::delete('/{id}', 'AdminMenuController@softDestroy');
		Route::get('/{id}', 'AdminMenuController@softGetOld');
	});

	// Department Menu
	Route::any('/admin-menu-dep', 'AdminMenuController@depIndex')->name('admin-menu-dep');
	Route::prefix('/admin-menu-dep')->group(function(){
		Route::post('/store', 'AdminMenuController@depStore')->name('store-dep-menu');
		Route::post('/update', 'AdminMenuController@depUpdate')->name('update-dep-menu');
		Route::delete('/{id}', 'AdminMenuController@depDelete');
		Route::get('/{id}', 'AdminMenuController@depMenuOld');
	});
	Route::any('/admin-menu-dep-sub', 'AdminMenuController@depSubIndex')->name('admin-menu-dep-sub');
	Route::prefix('/admin-menu-dep-sub')->group(function(){
		Route::post('/store', 'AdminMenuController@depSubStore')->name('store-dep-sub-menu');
		Route::post('/update', 'AdminMenuController@depSubUpdate')->name('update-dep-sub-menu');
		Route::delete('/{id}', 'AdminMenuController@depSubDelete');
		Route::get('/{id}', 'AdminMenuController@depSubMenuOld');
	});

	// Soft Controller to add, update and delete software
	Route::resource('/admin-soft', 'SoftController');
	Route::post('/admin-soft/search', 'SoftController@searchIndex')->name('admin-soft.search');

	// Ip Phone Controller to add, update and delete ip details
	Route::any('/admin-ip', 'IpPhoneController@adminIpIndex')->name('admin-ip');
	Route::prefix('/admin-ip')->group(function(){
		Route::post('/store', 'IpPhoneController@adminIpStore')->name('store-ip');
		Route::post('/update', 'IpPhoneController@adminIpUpdate')->name('update-ip');
		Route::delete('/{id}', 'IpPhoneController@adminIpDelete');
		Route::get('/{id}', 'IpPhoneController@adminIpOld');
		Route::get('/fetch-sub-dep/{id}', 'IpPhoneController@adminGetSubDep');
		Route::get('/{id}', 'IpPhoneController@adminIpOld');
	});

	// News Control
	Route::resource('/news', 'NewsController');
	Route::prefix('/news')->group(function(){
		Route::post('/search', 'NewsController@indexSearch')->name('news.search');
	});

});

