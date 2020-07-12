<?php

use Illuminate\Http\Request;

Route::post('/login','UserController@login');
Route::post('/register','UserController@register');
Route::post('/recover','UserController@recover');

Route::resource('/products','ProductsCotroller')->except([
    'create','edit'
]);

Route::group(['middleware'=>'auth.jwt'],function(){
  
    Route::post('/logout','UserController@logout');

    Route::get('test',function(){
        return response()->json([
            'foot'=>'bar'
        ]);
    });

    Route::get('/categorias/select','CategoriaController@select');
});

Route::get('/', function () {
    return 'mario';
});
