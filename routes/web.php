<?php

use App\Http\Controllers\Usuarios;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pedidos;
use App\Http\Controllers\Clientes;
use App\Http\Controllers\Produtos;

//FRONTEND
Route::get('/', function (){if(!Auth::check()){return view('auth.login');}else{return redirect()->route('clientes.index');}})->name('login');
Route::post('/', [Usuarios::class,'login'])->name('login.post');

Route::middleware('auth')->group(function () {
    Route::get('/logout', [Usuarios::class,'logout'])->name('login.logout');
    Route::prefix('clientes')->name('clientes.')->group(function(){
        Route::view('/', 'clientes.index')->name('index');
        Route::view('/criar', 'clientes.create')->name('create');
        Route::view('/ver/{codigo}', 'clientes.view')->name('view');
        Route::view('/editar/{codigo}', 'clientes.edit')->name('edit');
    });
    Route::prefix('produtos')->name('produtos.')->group(function(){
        Route::view('/', 'produtos.index')->name('index');
        Route::view('/criar', 'produtos.create')->name('create');
        Route::view('/ver/{codigo}', 'produtos.view')->name('view');
        Route::view('/editar/{codigo}', 'produtos.edit')->name('edit');
    });
    Route::prefix('pedidos')->name('pedidos.')->group(function(){
        Route::view('/', 'pedidos.index')->name('index');
        Route::view('/criar', 'pedidos.create')->name('create');
        Route::view('/ver/{codigo}', 'pedidos.view')->name('view');
        Route::view('/editar/{codigo}', 'pedidos.edit')->name('edit');
    });

    Route::prefix('usuarios')->name('usuarios.')->group(function(){
        Route::view('/', 'usuarios.index')->name('index');
        Route::view('/criar', 'usuarios.create')->name('create');
        Route::view('/ver/{codigo}', 'usuarios.view')->name('view');
        Route::view('/editar/{codigo}', 'usuarios.edit')->name('edit');
    });
});

Route::middleware('auth')->group(function () {
    Route::prefix('api')->name('api.')->group(function(){
        Route::controller(Clientes::class)->prefix('clientes')->name('clientes.')->group(function(){
            Route::get('/get', 'getAll')->name('get');
            Route::get('/get/{id}', 'get')->name('getById');
            Route::post('/store','store')->name('store');
            Route::put('/update/{codigo}','update')->name('update');
            Route::delete('/delete/{codigo}','destroy')->name('delete');
            Route::delete('/delete','destroyMass')->name('deleteMass');
        });
        Route::controller(Produtos::class)->prefix('produtos')->name('produtos.')->group(function(){
            Route::get('/get', 'getAll')->name('get');
            Route::get('/get/{id}', 'get')->name('getById');
            Route::post('/store','store')->name('store');
            Route::put('/update/{codigo}','update')->name('update');
            Route::delete('/delete/{codigo}','destroy')->name('delete');
            Route::delete('/delete','destroyMass')->name('deleteMass');
        });
        Route::controller(Pedidos::class)->prefix('pedidos')->name('pedidos.')->group(function(){
            Route::get('/get', 'getAll')->name('get');
            Route::get('/get/{id}', 'get')->name('getById');
            Route::post('/store','store')->name('store');
            Route::put('/update/{codigo}','update')->name('update');
            Route::delete('/delete/{codigo}','destroy')->name('delete');
            Route::delete('/delete','destroyMass')->name('deleteMass');
        });
        Route::controller(Usuarios::class)->prefix('usuarios')->name('usuarios.')->group(function(){
            Route::get('/get', 'getAll')->name('get');
            Route::get('/get/{id}', 'get')->name('getById');
            Route::post('/store','store')->name('store');
            Route::put('/update/{codigo}','update')->name('update');
            Route::delete('/delete/{codigo}','destroy')->name('delete');
            Route::delete('/delete','destroyMass')->name('deleteMass');
        });
    });
});
