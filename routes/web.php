<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');


Route::get('posts', function(){
	$posts = \App\Post::paginate(10);

	return response()->json($posts,200);
});


Route::post('posts', function(){
	$post = \App\Post::create(request()->all());

	return response()->json($post,200);
});


Route::delete('posts/{id}', function($id){
	$post = \App\Post::destroy($id);
	if($post)
		return response()->json($post,200);
	return response()->json($post,422);
});
