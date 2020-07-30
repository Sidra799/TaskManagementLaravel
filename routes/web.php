<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/login', ['uses' => 'LoginController@show'])->name('login');
Route::post('/loginAction', 'LoginController@login');
Route::get('/forgetPassword', 'LoginController@viewforgetPassword');
Route::post('/forgetPasswordAction', 'LoginController@forgetPassword');

Route::get('/forgetPassword/{id}/{token}', 'LoginController@forgetPasswordPage');
Route::post('/changePasswordAction', 'LoginController@forgetPasswordAction');


Route::get('/register', ['uses' => 'registerController@show'])->name('register');
Route::post('registerAction', 'registerController@registerUser');
Route::get('email_verification/{code}', 'registerController@confirmEmail');

//*********** Routes with middleware to check if accesstoke is maintained in sessions ***********/
$router->group(['middleware' => 'checkSession'], function () use ($router) {
    $router->get('/home', 'homeController@show')->name('home');
    $router->post('/editUserAction', 'homeController@editUser');
    $router->post('/addUser', 'homeController@addUser');
    $router->get('/addUser', 'homeController@addUserShow')->middleware('checkPermission:read');

    $router->post('/addTask', 'homeController@addTask');
    $router->get('/addTask', 'homeController@addTaskShow')->middleware('checkPermission:write');
 
    $router->get('/editTask/{id}', 'taskController@show')->name('editTask');
    $router->post('/editTask/editTaskAction', 'taskController@editTask');
    $router->get('/delete-task/{id}', 'taskController@deteleTask')->middleware('checkPermission:write');
    $router->get('/askQuery/{id}', 'taskController@askQuery');
    $router->get('/status', 'statusController@show')->name('status');
    $router->get('/permission', 'permissionController@show')->name('permission');
    $router->post('/addPermission', 'permissionController@addPermission');
    $router->post('/updatePermission', 'permissionController@updatePermission');
    $router->get('delete-permission/{id}','permissionController@deletePermission');

    $router->get('/roles', 'roleController@show')->name('roles');
    $router->post('/addRole', 'roleController@addRole');
    $router->post('/updateRole', 'roleController@updateRole');
    $router->get('/getEditRoleData/{id}','roleController@getEditRoleData');
    $router->get('delete-role/{id}','roleController@deleteRole');
    $router->get('/getRoleById/{id}','roleController@getRoleById');

    $router->post('/addStatus', 'statusController@addStatus');
    $router->post('/updateStatus', 'statusController@updateStatus');
    $router->get('/delete-status/{id}', 'statusController@deteleStatus');
    $router->post('/editTask/editTaskStatus', 'taskController@updateStatus');
    $router->post('/filterTaskAction', 'homeController@filterTask');
    $router->get('/logout', 'homeController@logout');
});
