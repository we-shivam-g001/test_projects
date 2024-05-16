<?php

Route::group(
    [
    'prefix' => 'projects/projects',
    
    'middleware' => ['web'],
    
    'namespace' => 'Frontend',
],
function () {
     //---------------------------------------------------------
    Route::get('/assets', 'ProjectsController@getAssets')
        ->name('vh.frontend.projects.projects.assets');
    //---------------------------------------------------------
    Route::get('/', 'ProjectsController@getList')
        ->name('vh.frontend.projects.projects.list');
    //---------------------------------------------------------
    Route::match(['put', 'patch'], '/', 'ProjectsController@updateList')
        ->name('vh.frontend.projects.projects.list.updates');
    //---------------------------------------------------------
    Route::delete('/', 'ProjectsController@deleteList')
        ->name('vh.frontend.projects.projects.list.delete');
    //---------------------------------------------------------
    Route::post('/', 'ProjectsController@createItem')
        ->name('vh.frontend.projects.projects.create');
    //---------------------------------------------------------
    Route::get('/{id}', 'ProjectsController@getItem')
        ->name('vh.frontend.projects.projects.read');
    //---------------------------------------------------------
    Route::match(['put', 'patch'], '/{id}', 'ProjectsController@updateItem')
        ->name('vh.frontend.projects.projects.update');
    //---------------------------------------------------------
    Route::delete('/{id}', 'ProjectsController@deleteItem')
        ->name('vh.frontend.projects.projects.delete');
    //---------------------------------------------------------

});
