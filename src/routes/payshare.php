<?php

use Davidle90\Payshare\app\Http\Controllers\PayshareController;
use Illuminate\Support\Facades\Route;

Route::get('projects/payshare', [PayshareController::class, 'index'])->name('payshare.index');

Route::get('projects/payshare/groups/create', [PayshareController::class, 'create'])->name('payshare.groups.create');
Route::get('projects/payshare/groups/{id}', [PayshareController::class, 'view'])->name('payshare.groups.view');
Route::get('projects/payshare/groups/edit/{id}', [PayshareController::class, 'edit'])->name('payshare.groups.edit');
Route::post('projects/payshare/groups/store', [PayshareController::class, 'store'])->name('payshare.groups.store');
Route::post('projects/payshare/groups/delete', [PayshareController::class, 'delete'])->name('payshare.groups.delete');

Route::group(['middleware' => ['web', 'auth']], function () {

    //

});