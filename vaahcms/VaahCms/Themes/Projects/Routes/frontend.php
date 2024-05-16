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
include ("frontend/routes-auth.php");
include ("frontend/routes-projects.php");
Route::group(
    [
        'prefix'     => '/',
        'middleware' => ['web'],
        'namespace' => 'Frontend',
    ],
    function () {
        //------------------------------------------------

        Route::get( '/', 'FrontendController@index' )
        ->name( 'vh.frontend.projects' );
        Route::get( '/home', 'FrontendController@getHome' )
        ->name( 'vh.frontend.projects' );

        //------------------------------------------------
    });
