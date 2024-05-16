<?php
use VaahCms\Modules\Project\Http\Controllers\Backend\ProductsController;
/*
 * API url will be: <base-url>/public/api/project/products
 */
Route::group(
    [
        'prefix' => 'project/products',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', [ProductsController::class, 'getAssets'])
        ->name('vh.backend.project.api.products.assets');
    /**
     * Get List
     */
    Route::get('/', [ProductsController::class, 'getList'])
        ->name('vh.backend.project.api.products.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', [ProductsController::class, 'updateList'])
        ->name('vh.backend.project.api.products.list.update');
    /**
     * Delete List
     */
    Route::delete('/', [ProductsController::class, 'deleteList'])
        ->name('vh.backend.project.api.products.list.delete');


    /**
     * Create Item
     */
    Route::post('/', [ProductsController::class, 'createItem'])
        ->name('vh.backend.project.api.products.create');
    /**
     * Get Item
     */
    Route::get('/{id}', [ProductsController::class, 'getItem'])
        ->name('vh.backend.project.api.products.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', [ProductsController::class, 'updateItem'])
        ->name('vh.backend.project.api.products.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', [ProductsController::class, 'deleteItem'])
        ->name('vh.backend.project.api.products.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', [ProductsController::class, 'listAction'])
        ->name('vh.backend.project.api.products.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', [ProductsController::class, 'itemAction'])
        ->name('vh.backend.project.api.products.item.action');



});
