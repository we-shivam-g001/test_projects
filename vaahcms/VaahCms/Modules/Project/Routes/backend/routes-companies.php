<?php

use VaahCms\Modules\Project\Http\Controllers\Backend\CompaniesController;

Route::group(
    [
        'prefix' => 'backend/project/companies',

        'middleware' => ['web', 'has.backend.access'],

],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', [CompaniesController::class, 'getAssets'])
        ->name('vh.backend.project.companies.assets');
    /**
     * Get List
     */
    Route::get('/', [CompaniesController::class, 'getList'])
        ->name('vh.backend.project.companies.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', [CompaniesController::class, 'updateList'])
        ->name('vh.backend.project.companies.list.update');
    /**
     * Delete List
     */
    Route::delete('/', [CompaniesController::class, 'deleteList'])
        ->name('vh.backend.project.companies.list.delete');


    /**
     * Fill Form Inputs
     */
    Route::any('/fill', [CompaniesController::class, 'fillItem'])
        ->name('vh.backend.project.companies.fill');

    /**
     * Create Item
     */
    Route::post('/', [CompaniesController::class, 'createItem'])
        ->name('vh.backend.project.companies.create');
    /**
     * Get Item
     */
    Route::get('/{id}', [CompaniesController::class, 'getItem'])
        ->name('vh.backend.project.companies.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', [CompaniesController::class, 'updateItem'])
        ->name('vh.backend.project.companies.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', [CompaniesController::class, 'deleteItem'])
        ->name('vh.backend.project.companies.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', [CompaniesController::class, 'listAction'])
        ->name('vh.backend.project.companies.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', [CompaniesController::class, 'itemAction'])
        ->name('vh.backend.project.companies.item.action');

    //---------------------------------------------------------
    Route::post('/search/contacts', [CompaniesController::class, 'searchContacts'])
        ->name('vh.backend.store.companies.search.contacts');

    Route::get('/get-contact-list/{id}', [CompaniesController::class, 'getContactsList'])
        ->name('vh.backend.store.companies.get.contact-list');

    Route::post('/save/with-existing-company', [CompaniesController::class, 'saveWithExistingCompany'])
        ->name('vh.backend.store.companies.search.contacts');

    Route::post('/create/new-contact', [CompaniesController::class, 'createNewContact'])
        ->name('vh.backend.store.contacts.search.company');
});
