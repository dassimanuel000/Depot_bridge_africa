<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//use Illuminate\Auth;

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

Route::redirect('/', 'login', 302);

Route::group(['middleware' => ['auth', 'admin']], function(){

    Route::get('/dashboard', function(){
        return view('index');
    });

    ///PRODUCT

    Route::get('/add_product','dashboard_controller@add_product')->name('admin.add_product');

    Route::get('/list_product','dashboard_controller@list_product')->name('admin.list_product');

    Route::post('/form_add_product', 'dashboard_controller@form_add_product')->name('form_add_product');

    Route::get('/search_product', 'dashboard_controller@search_product')->name('search_product');

    Route::get('/search','dashboard_controller@search')->name('search');    

    Route::get('/edit_product/{id}', 'dashboard_controller@edit_product')->name('edit_product');

    Route::get('/show_product/{id}', 'dashboard_controller@show_product')->name('show_product');

    Route::put('/form_edit_product/{id}', 'dashboard_controller@form_edit_product')->name('form_edit_product');

    Route::get('/delete_product/{id}', function ($id) {
        $delete = DB::delete('delete FROM product where id = '.$id.' ');
        return redirect()->back()->with('success', 'success');
    });



    //////////////////////


    Route::get('/form_add_family', 'dashboard_controller@form_add_family')->name('form_add_family');

    Route::get('/form_add_type', 'dashboard_controller@form_add_type')->name('form_add_type');

    Route::get('/form_add_categorie', 'dashboard_controller@form_add_categorie')->name('form_add_categorie');

    Route::post('/form_add_product', 'dashboard_controller@form_add_product')->name('form_add_product');


});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
