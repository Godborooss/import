<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ItemController;
use App\Http\Controllers\PackController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::put('/packs/{pack}', [PackController::class, 'update'])->name('packs.update');
Route::controller(ItemController::class)->group(function(){
    Route::get('items', 'index');
    Route::get('items-export', 'export')->name('items.export');
    Route::post('items-import', 'import')->name('items.import');
    Route::get('/packs/{pack}', 'show')->name('items.show');
//    Route::get('autocomplete', 'autocomplete')->name('autocomplete');
});

Route::controller(\App\Http\Controllers\PackController::class)->group(function(){
    Route::get('packs', 'index');
    Route::get('/packs/{pack}', 'show')->name('packitems.show');
});
//Route::get('packages-show', 'show')->name('items.show');
//Route::get('/packs/{pack}', [ItemController::class, 'show'])->name('items.show');
Route::post('/packs/', [ItemController::class, 'update'])->name('items.update')->middleware('auth');
Route::get('autocomplete',[ItemController::class , 'autocomplete'])->name('autocomplete');


Route::post('packs/update', [ItemController::class, 'update'])->name('items.update');

Route::post('/packs/', [ItemController::class, 'updateItem'])->name('update-item');
Route::post('/packs/', [PackController::class, 'storeCompany'])->name('companies.store');



    //Route::middleware(['auth', CheckPackOwner::class])->group(function () {
    //    Route::get('packs', [PackController::class, 'index']);
    //    Route::get('/packs/{pack}', [PackController::class, 'show'])->name('packitems.show');
    //});
Route::get('/xmlaction', [\App\Http\Controllers\XmlimportController::class, 'index'])->name('import.show');
Route::post('/xmlaction', [\App\Http\Controllers\XmlimportController::class, 'import'])->name('xmlimport.import');
Route::get('/xmlaction', [\App\Http\Controllers\XmlimportController::class, 'exportindex'])->name('export-index');
Route::get('/xmlaction/{id}', [\App\Http\Controllers\XmlimportController::class, 'exportXmlpacks'])->name('exportxml');

Route::post('/packs/{pack}/create-xml', [PackController::class, 'createXml'])->name('create-xml');
Route::middleware(['auth', 'check.pack.owner'])->group(function () {
    Route::get('/packs', [PackController::class, 'index'])->name('packs.index');

    Route::resource('senders', \App\Http\Controllers\SenderController::class);
    Route::resource('taxcodes', \App\Http\Controllers\TaxcodeController::class);
    Route::resource('receivers', \App\Http\Controllers\ReceiverController::class);
    Route::resource('brokers', \App\Http\Controllers\BrokerController::class);
    Route::get('/packs/{id}', [PackController::class, 'show'])->name('packs.show');
});
Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index']);

Route::get('/senders/search', 'SenderController@search')->name('search.senders');


