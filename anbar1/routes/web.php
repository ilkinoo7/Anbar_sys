<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\Data_Controllers\brandsDataController;
use App\Http\Controllers\Data_Controllers\clientsDataController;
use App\Http\Controllers\Data_Controllers\productsDataController;
use App\Http\Controllers\Data_Controllers\ordersDataController;

Route::group(['middleware'=>'NotLogin'],function(){

    #DATA CONTROLLERS START
    
    Route::get('brands_data', [brandsDataController::class, 'index']);
    Route::post('add-update-brand', [brandsDataController::class, 'store']);
    Route::post('edit-brand', [brandsDataController::class, 'edit']);
    Route::post('brands_delete', [brandsDataController::class, 'destroy']);

    Route::get('clients_data', [clientsDataController::class, 'index'])->name('clients_data');
    Route::post('add-update-client', [clientsDataController::class, 'store']);
    Route::post('edit-client', [clientsDataController::class, 'edit']);
    Route::post('delete-client', [clientsDataController::class, 'destroy']);

    Route::get('products_data', [productsDataController::class, 'index'])->name('products_data');
    Route::post('add-update-product', [productsDataController::class, 'store']);
    Route::post('edit-product', [productsDataController::class, 'edit']);
    Route::post('delete-product', [productsDataController::class, 'destroy']);

    Route::get('orders_data', [ordersDataController::class, 'index'])->name('orders_data');
    Route::post('add-update-order', [ordersDataController::class, 'store']);
    Route::post('edit-order', [ordersDataController::class, 'edit']);
    Route::post('delete-order', [ordersDataController::class, 'destroy']);



    Route::get('send-mail', function(){
        $details=[
            'title'=>'Mail from Meshtaginskiy',
            'body'=>'Bu bir test maildir'
        ];
        Mail::to('agacanov-ilkin@mail.ru')->send(new \App\Mail\MyTestMail($details));

        dd('Mail.ru-ya gonderildi');
    });

    Route::get('/test', function () {
        return view('test');
    })->name('test');


    Route::get('/expenses', function () {
        return view('expenses');
    })->name('expenses');
    
    //PRODUCT START
    
    Route::get('/product','App\Http\Controllers\productController@plist')->name('plist');
    Route::post('/gonder3','App\Http\Controllers\productController@productForm')->name('productForm');
    Route::get('/psil/{id}','App\Http\Controllers\productController@psil')->name('psil');
    Route::get('/pdelete/{id}','App\Http\Controllers\productController@pdelete')->name('pdelete');
    Route::get('/pedit/{id}','App\Http\Controllers\productController@pedit')->name('pedit');
    Route::post('/pupdate','App\Http\Controllers\productController@pupdate')->name('pupdate');
    
    //PRODUCT END
    
    
    
    //CLIENT START
    
    Route::get('/client','App\Http\Controllers\clientController@clist')->name('clist');
    Route::post('/gonder2','App\Http\Controllers\clientController@clientForm')->name('clientForm');
    Route::get('/csil/{id}','App\Http\Controllers\clientController@csil')->name('csil');
    Route::get('/cdelete/{id}','App\Http\Controllers\clientController@cdelete')->name('cdelete');
    Route::get('/cedit/{id}','App\Http\Controllers\clientController@cedit')->name('cedit');
    Route::post('/cupdate','App\Http\Controllers\clientController@cupdate')->name('cupdate');
    
    //CLIENT END
    
    //BRAND START
    
    Route::get('/bsil/{id}','App\Http\Controllers\brandController@bsil')->name('bsil');
    Route::get('/brand','App\Http\Controllers\brandController@blist')->name('blist');
    Route::get('/bedit/{id}','App\Http\Controllers\brandController@bedit')->name('bedit');
    Route::post('/bupdate','App\Http\Controllers\brandController@bupdate')->name('bupdate');
    Route::get('/bdelete/{id}','App\Http\Controllers\brandController@bdelete')->name('bdelete');
    //Route::post('/bimtina','App\Http\Controllers\brandController@bimtina')->name('bimtina');
    
    Route::post('/gonder1','App\Http\Controllers\brandController@brandForm')->name('brandForm');
    // BRAND END
    
    //ORDER START
    
    Route::get('/order','App\Http\Controllers\orderController@olist')->name('olist');
    Route::post('/gonder4','App\Http\Controllers\orderController@orderForm')->name('orderForm');
    Route::get('/osil/{id}','App\Http\Controllers\orderController@osil')->name('osil');
    Route::get('/odelete/{id}','App\Http\Controllers\orderController@odelete')->name('odelete');
    Route::get('/oedit/{id}','App\Http\Controllers\orderController@oedit')->name('oedit');
    Route::post('/oupdate','App\Http\Controllers\orderController@oupdate')->name('oupdate');
    Route::post('/otesdiq','App\Http\Controllers\ordersDataController@otesdiq')->name('otesdiq');
    Route::post('/olegvet','App\Http\Controllers\ordersDataController@olegvet')->name('olegvet');
    
    //ORDER END

    Route::get('/logout','App\Http\Controllers\UserController@logout')->name('logout');

});        



Route::group(['middleware'=>'IsLogin'],function(){

    
    Route::get('/', function () {
        return view('login');
    })->name('login');
    
    Route::post('/','App\Http\Controllers\UserController@login')->name('signin');
    
    Route::get('/user','App\Http\Controllers\UserController@ulist')->name('ulist');
    Route::post('/gonder5','App\Http\Controllers\UserController@userForm')->name('userForm');
    
});
