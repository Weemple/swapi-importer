<?php

use Illuminate\Support\Facades\Route;

use Weemple\SwapiImporter\Controllers\ApiController;

Route::prefix('api')->group(function () {
    Route::get('people', [ApiController::class, 'getPeoples']);
    Route::get('people/{id}', [ApiController::class, 'getPeople']);
});
