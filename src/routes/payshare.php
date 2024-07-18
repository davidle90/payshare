<?php

use Davidle90\Payshare\app\Http\Controllers\PayshareController;
use Illuminate\Support\Facades\Route;

Route::get('projects/payshare', [PayshareController::class, 'index'])->name('payshare.index');

Route::group(['middleware' => ['web', 'auth']], function () {

    //

});