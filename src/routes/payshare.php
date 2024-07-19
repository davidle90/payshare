<?php

use Davidle90\Payshare\app\Http\Controllers\PayshareController;
use Davidle90\Payshare\app\Http\Controllers\GroupsController;
use Davidle90\Payshare\app\Http\Controllers\MembersController;
use Davidle90\Payshare\app\Http\Controllers\PaymentsController;

use Illuminate\Support\Facades\Route;

Route::get('projects/payshare', [PayshareController::class, 'index'])->name('payshare.index');

Route::get('projects/payshare/groups/create', [GroupsController::class, 'create'])->name('payshare.groups.create');
Route::get('projects/payshare/groups/{id}', [GroupsController::class, 'view'])->name('payshare.groups.view');
Route::get('projects/payshare/groups/edit/{id}', [GroupsController::class, 'edit'])->name('payshare.groups.edit');
Route::post('projects/payshare/groups/store', [GroupsController::class, 'store'])->name('payshare.groups.store');
Route::post('projects/payshare/groups/delete', [GroupsController::class, 'delete'])->name('payshare.groups.delete');

Route::get('projects/payshare/groups/{group_id}/members/create', [MembersController::class, 'create'])->name('payshare.members.create');
Route::get('projects/payshare/groups/{group_id}/members/edit/{member_id}', [MembersController::class, 'edit'])->name('payshare.members.edit');
Route::post('projects/payshare/groups/{group_id}/members/store', [MembersController::class, 'store'])->name('payshare.members.store');
Route::post('projects/payshare/groups/{group_id}/members/delete', [MembersController::class, 'delete'])->name('payshare.members.delete');

Route::get('projects/payshare/groups/{group_id}/payments/create', [PaymentsController::class, 'create'])->name('payshare.payments.create');
Route::get('projects/payshare/groups/{group_id}/payments/edit/{payment_id}', [PaymentsController::class, 'edit'])->name('payshare.payments.edit');
Route::post('projects/payshare/groups/{group_id}/payments/store', [PaymentsController::class, 'store'])->name('payshare.payments.store');
Route::post('projects/payshare/groups/{group_id}/payments/delete', [PaymentsController::class, 'delete'])->name('payshare.payments.delete');


Route::group(['middleware' => ['web', 'auth']], function () {

    //

});