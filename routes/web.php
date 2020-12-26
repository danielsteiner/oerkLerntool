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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/imprint', function () {
    return view('pages.disclaimer');
});
Route::get('/thanksforthebeer', function () {
    return view('pages.thanksforthebeer');
});

Auth::routes();
Route::impersonate();
Route::middleware(['auth'])->group(function () {
    Route::resource('/tests', 'TestController');
    Route::resource('/user', 'UserController');
    Route::get('/tests/{id}/simulation', 'TestController@simulation');
    Route::post('/tests/{id}/simulation/auswerten', 'TestController@auswerten');
    Route::get('/tests/{test_id}/simulation/{attempt_id}', 'TestController@result');
    Route::get('/lernkartei/{test_id}/level/{level_id}', 'TestController@lernkartei');
    Route::post('/lernkartei/{test_id}/answer', 'TestController@karteianswer');
    Route::post('/{test_id}/answer', 'TestController@karteianswer');
    Route::get('/admin', 'AdminController@admin')->middleware('is_admin');
    Route::get('/admin/statistik', 'AdminController@statistik')->middleware('is_admin');
    Route::get('/admin/users', 'AdminController@users')->middleware('is_admin');
    Route::get('/export/tests/{test_id}', 'QuestionController@exportTest')->name('exportTest');
    Route::get('/export/tests/{test_id}/{prechecked}', 'QuestionController@exportTest')->name('exportTest');
});
