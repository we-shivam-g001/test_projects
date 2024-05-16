<?php
use VaahCms\Modules\Project\Http\Controllers\Backend\ContactsController;
/*
 * API url will be: <base-url>/public/api/project/contacts
 */
Route::group(
    [
        'prefix' => 'project/contacts',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', [ContactsController::class, 'getAssets'])
        ->name('vh.backend.project.api.contacts.assets');
    /**
     * Get List
     */
    Route::get('/', [ContactsController::class, 'getList'])
        ->name('vh.backend.project.api.contacts.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', [ContactsController::class, 'updateList'])
        ->name('vh.backend.project.api.contacts.list.update');
    /**
     * Delete List
     */
    Route::delete('/', [ContactsController::class, 'deleteList'])
        ->name('vh.backend.project.api.contacts.list.delete');


    /**
     * Create Item
     */
    Route::post('/', [ContactsController::class, 'createItem'])
        ->name('vh.backend.project.api.contacts.create');
    /**
     * Get Item
     */
    Route::get('/{id}', [ContactsController::class, 'getItem'])
        ->name('vh.backend.project.api.contacts.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', [ContactsController::class, 'updateItem'])
        ->name('vh.backend.project.api.contacts.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', [ContactsController::class, 'deleteItem'])
        ->name('vh.backend.project.api.contacts.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', [ContactsController::class, 'listAction'])
        ->name('vh.backend.project.api.contacts.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', [ContactsController::class, 'itemAction'])
        ->name('vh.backend.project.api.contacts.item.action');



});
