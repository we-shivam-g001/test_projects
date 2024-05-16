<?php
use VaahCms\Modules\Project\Http\Controllers\Backend\CompaniesController;
/*
 * API url will be: <base-url>/public/api/project/companies
 */
Route::group(
    [
        'prefix' => 'project/companies',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', [CompaniesController::class, 'getAssets'])
        ->name('vh.backend.project.api.companies.assets');
    /**
     * Get List
     */
    Route::get('/', [CompaniesController::class, 'getList'])
        ->name('vh.backend.project.api.companies.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', [CompaniesController::class, 'updateList'])
        ->name('vh.backend.project.api.companies.list.update');
    /**
     * Delete List
     */
    Route::delete('/', [CompaniesController::class, 'deleteList'])
        ->name('vh.backend.project.api.companies.list.delete');


    /**
     * Create Item
     */
    Route::post('/', [CompaniesController::class, 'createItem'])
        ->name('vh.backend.project.api.companies.create');
    /**
     * Get Item
     */
    Route::get('/{id}', [CompaniesController::class, 'getItem'])
        ->name('vh.backend.project.api.companies.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', [CompaniesController::class, 'updateItem'])
        ->name('vh.backend.project.api.companies.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', [CompaniesController::class, 'deleteItem'])
        ->name('vh.backend.project.api.companies.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', [CompaniesController::class, 'listAction'])
        ->name('vh.backend.project.api.companies.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', [CompaniesController::class, 'itemAction'])
        ->name('vh.backend.project.api.companies.item.action');



});
