<?php

Route::get('/', function () {
    return view('coba');
});

Route::get('shop', 'ProductController@index')->name('shop');

Route::prefix('shop/product')->group(function(){
	Route::get('/', 'ProductController@index')->name('product.index');
	Route::get('datatable', 'ProductController@datatable')->name('product.dt');
	Route::get('show/{id}', 'ProductController@show')->name('product.show');
	Route::get('create', 'ProductController@create')->name('product.create');
	Route::post('store', 'ProductController@store')->name('product.store');
	Route::get('edit/{id}', 'ProductController@edit')->name('product.edit');
	Route::put('update/{id}', 'ProductController@update')->name('product.update');
	Route::delete('delete/{id}', 'ProductController@delete')->name('product.delete');
});

Route::prefix('shop/category')->group(function(){
	Route::get('/', 'CategoryController@index')->name('category.index');
	Route::get('datatable', 'CategoryController@datatable')->name('category.dt');
	Route::get('show/{id}', 'CategoryController@show')->name('category.show');
	Route::get('create', 'CategoryController@create')->name('category.create');
	Route::post('store', 'CategoryController@store')->name('category.store');
	Route::get('edit/{id}', 'CategoryController@edit')->name('category.edit');
	Route::put('update/{id}', 'CategoryController@update')->name('category.update');
	Route::delete('delete/{id}', 'CategoryController@delete')->name('category.delete');
});

Route::prefix('shop/brand')->group(function(){
	Route::get('/', 'BrandController@index')->name('brand.index');
	Route::get('datatable', 'BrandController@datatable')->name('brand.dt');
	Route::get('show/{id}', 'BrandController@show')->name('brand.show');
	Route::get('create', 'BrandController@create')->name('brand.create');
	Route::post('store', 'BrandController@store')->name('brand.store');
	Route::get('edit/{id}', 'BrandController@edit')->name('brand.edit');
	Route::put('update/{id}', 'BrandController@update')->name('brand.update');
	Route::delete('delete/{id}', 'BrandController@delete')->name('brand.delete');
});