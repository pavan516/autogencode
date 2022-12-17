<?php

# utilities
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Default Route To Template Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return view('welcome'); });
Route::post('/contactus', 'ContactUsController@index')->name('contactus');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/home', 'HomeController@index')->name('home');

/*
|--------------------------------------------------------------------------
| Projects
|--------------------------------------------------------------------------
*/
Route::get('/projects', 'ProjectsController@index')->name('projects');
Route::post('/projects/create', 'ProjectsController@create')->name('projects.create');
Route::get('/project/show/{uuid}', 'ProjectsController@show');
Route::delete('/projects/delete/{uuid}', 'ProjectsController@destroy');

/*
|--------------------------------------------------------------------------
| Tables
|--------------------------------------------------------------------------
*/
Route::get('/tables/{project_uuid}', 'TablesController@index');
Route::post('/tables/create', 'TablesController@create')->name('tables.create');
Route::get('/tables/{database_uuid}/{table_uuid}/{count}', 'TablesController@getTables');

/*
|--------------------------------------------------------------------------
| Attributes
|--------------------------------------------------------------------------
*/
Route::post('/atributes/create', 'AttributesController@create')->name('attributes.create');

/*
|--------------------------------------------------------------------------
| Databases
|--------------------------------------------------------------------------
*/
Route::get('/databases/{project_uuid}', 'DatabasesController@index');
Route::post('/databases/create', 'DatabasesController@create')->name('databases.create');

/*
|--------------------------------------------------------------------------
| Features
|--------------------------------------------------------------------------
*/
Route::get('/features/{project_uuid}', 'FeaturesController@index');
Route::post('/features/create', 'FeaturesController@create')->name('features.create');

/*
|--------------------------------------------------------------------------
| Framework
|--------------------------------------------------------------------------
*/
Route::get('/framework/codeigniter/{project_uuid}', 'FrameworkController@codeigniter');
Route::get('/framework/laravel/{project_uuid}', 'FrameworkController@laravel');
Route::get('/framework/express/mysql/{project_uuid}', 'FrameworkController@expressMysql');

/*
|--------------------------------------------------------------------------
| Laravel Code generator
|--------------------------------------------------------------------------
*/
Route::get('/generate/laravel/{project_uuid}', 'MyLaravelController@generate');

/*
|--------------------------------------------------------------------------
| Codeigniter Code generator
|--------------------------------------------------------------------------
*/
Route::get('/generate/codeigniter/{project_uuid}', 'MyCodeigniterController@generate');

/*
|--------------------------------------------------------------------------
| Node Js - Express Code generator
|--------------------------------------------------------------------------
*/
Route::get('/generate/express/mysql/{project_uuid}', 'NodeJs\ExpressJsController@generateMysql');