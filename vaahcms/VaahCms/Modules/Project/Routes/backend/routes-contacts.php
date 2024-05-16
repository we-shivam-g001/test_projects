<?php

use VaahCms\Modules\Project\Http\Controllers\Backend\ContactsController;

Route::group(
    [
        'prefix' => 'backend/project/contacts',

        'middleware' => ['web', 'has.backend.access'],

],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', [ContactsController::class, 'getAssets'])
        ->name('vh.backend.project.contacts.assets');
    /**
     * Get List
     */
    Route::get('/', [ContactsController::class, 'getList'])
        ->name('vh.backend.project.contacts.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', [ContactsController::class, 'updateList'])
        ->name('vh.backend.project.contacts.list.update');
    /**
     * Delete List
     */
    Route::delete('/', [ContactsController::class, 'deleteList'])
        ->name('vh.backend.project.contacts.list.delete');


    /**
     * Fill Form Inputs
     */
    Route::any('/fill', [ContactsController::class, 'fillItem'])
        ->name('vh.backend.project.contacts.fill');

    /**
     * Create Item
     */
    Route::post('/', [ContactsController::class, 'createItem'])
        ->name('vh.backend.project.contacts.create');
    /**
     * Get Item
     */
    Route::get('/{id}', [ContactsController::class, 'getItem'])
        ->name('vh.backend.project.contacts.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', [ContactsController::class, 'updateItem'])
        ->name('vh.backend.project.contacts.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', [ContactsController::class, 'deleteItem'])
        ->name('vh.backend.project.contacts.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', [ContactsController::class, 'listAction'])
        ->name('vh.backend.project.contacts.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', [ContactsController::class, 'itemAction'])
        ->name('vh.backend.project.contacts.item.action');

    //---------------------------------------------------------
    Route::post('/search/companies', [ContactsController::class, 'searchCompanies'])
        ->name('vh.backend.store.contacts.search.company');

    Route::post('/create/new-company', [ContactsController::class, 'createCompany'])
        ->name('vh.backend.store.contacts.search.company');

    Route::post('/save/with-existing-company', [ContactsController::class, 'saveWithExistingCompany'])
        ->name('vh.backend.store.contacts.search.contacts');

    Route::any('/search/added/by', [ContactsController::class, 'searchAddedBy'] )
        ->name('vh.backend.store.contacts.search.Added');
});
