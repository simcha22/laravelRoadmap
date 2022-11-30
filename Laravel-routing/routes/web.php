<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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
})->name('welcome');

Route::redirect('/here', '/');

//Route::get('/user/{id}', function (Request $request, $id) {
//    dd($request);
//    return 'User '.$id;
//});

Route::get('/posts/{post}/comments/{comment}', function ($postId,  $commentId) {
    dd($postId);
});

//Route::get('/user/{name?}', function ($name = 'simcha') {
//    return $name;
//});

//Route::get('/user/{name?}', function ($name = 'John') {
//    return $name;
//});


Route::get('/user/{name}', function ($name) {
    //
})->where('name', '[A-Za-z]+');

//Route::get('/user/{id}', function ($id) {
//    //
//})->where('id', '[0-9]+');
//
Route::get('/user/{id}/{name}', function ($id, $name) {
    //
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);


Route::get('/search/{search}', function ($search) {
    return $search;
})->where('search', '.*');

Route::middleware('simple')->group(function (){
    Route::get('/simple/user');
    Route::get('/simple/user/b');
});

Route::controller(\App\Http\Controllers\HomeController::class)->group(function(){
    Route::get('/index/user', 'index');
    Route::get('/create/user', 'create');
});
//
//Route::prefix('admin')->group(function () {
//    Route::get('/users', function () {
//        dd('/admin/users" URL');
//    });
//});
//
//Route::name('admin.')->group(function () {
//    Route::get('/users', function () {
//        dd(\route("admin.users"));
//    })->name('users');
//});



//Route::get('/users/{user}', [\App\Http\Controllers\HomeController::class, 'update'])->withTrashed();
Route::get('/users/{user}', function (\App\Models\User $user){
  dd($user);
})->name('users');
//Route::scopeBindings()->group(function () {
//    Route::get('/users/{user}/posts/{post}', function (\App\Models\User $user, \App\Models\Post $post){
//        dd($post);
//    })->missing(function (Request $request) {
//        return \Illuminate\Support\Facades\Redirect::route('welcome');
//    });;
//});


//Route::get('/users/{user}/posts/{post:name}', function (\App\Models\User $user, \App\Models\Post $post) {
//    return $post;
//})->withoutScopedBindings();

Route::get('/categories/{category}', function (\App\Enums\Category $category) {
    return $category->value;
});


Route::fallback(function () {
    return \Illuminate\Support\Facades\Redirect::route('welcome');
});
