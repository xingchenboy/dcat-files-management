<?php

use Xingchenboy\DcatFilesManagement\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('media', Controllers\DcatFilesManagementController::class.'@index')->name('media-index');

Route::get('media/download', Controllers\DcatFilesManagementController::class.'@download')->name('media-download');

Route::delete('media/delete',  Controllers\DcatFilesManagementController::class.'@delete')->name('media-delete');

Route::put('media/move',  Controllers\DcatFilesManagementController::class.'@move')->name('media-move');

Route::post('media/upload',  Controllers\DcatFilesManagementController::class.'@upload')->name('media-upload');

Route::post('media/folder',  Controllers\DcatFilesManagementController::class.'@newFolder')->name('media-new-folder');
