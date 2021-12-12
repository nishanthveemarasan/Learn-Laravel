<?php

use App\Models\Proposal;
use Illuminate\Http\Request;
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

Route::get('/', function () {
    return view('welcome');
})->name('home.index');

Route::get('/posts/{id}', function (Request $request,  $id) {
    dd($request->all());
    return 'BlogPost ' . $id;
})->name('posts.get');

Route::get('/recent-posts/{daysAgo?}', function ($daysAgo = null) {
    return 'sd ' . $daysAgo;
});

Route::get('/redirect-name-route', function () {
    return redirect()->route('posts.get', ['id' => 1, 'photos' => 'yes']);
});


Route::prefix('users')->group(function () {
    Route::get('/get', function () {
        //matches users/get url
        return 'Welcome to users';
    });
});

Route::name('users')->group(function () {
    Route::get('/get', function () {
        return 'users';
        //Route will assign users.get name to this route
    })->name('get');
});
//create a post
Route::prefix('post')->group(function () {
    Route::get('/create', function () {
        $proposal = new Proposal();
        $proposal->title = 'second title';
        $proposal->content = 'come content';
        $proposal->save();
        return $proposal;
    });
    Route::get('/get/{uuid}', function (Proposal $proposal) {
        return $proposal;
    });
});
