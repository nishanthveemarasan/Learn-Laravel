<?php

use App\Http\Controllers\PostController;
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
Route::prefix('post')->name('posts.')->group(function () {
    Route::get('/create', function () {
        $proposal = new Proposal();
        $proposal->title = 'second title';
        $proposal->content = 'come content';
        $proposal->save();
        return $proposal;
    })->name('get');
    Route::get('/get/{uuid}', function (Proposal $proposal) {
        return $proposal;
    })->name('create');
});

/**
 * Request and Response
 */
Route::get('/fun/responses/{proposal:uuid}', function (Proposal $proposal) {
    return response($proposal, 201)->withHeaders(['Content-type' => 'application/json'])->cookie('MY_COOKIE', 'NIshanth', 3600);
});

Route::get('/fun/json/{proposal:uuid}', function (Proposal $proposal) {
    return response()->json([
        'name' => $proposal->toArray(),
    ]);
});

Route::get('/fun/download/{proposal:uuid}', function (Proposal $proposal) {
    //(pathName , name of the file , headers)
    return response()->download(public_path('/danial.jpg'), 'face.jpg', []);
});

//Request
Route::get('/send-request', function () {
    return redirect()->route('request.get', ['id' => 1, 'photos' => 'yes', 'table' => 'no']);
});
Route::get('access-request', function (Request $request) {
    //access all requests
    //dd($request->all());
    $all = $request->all();
    ///access a specific request
    $photos = $request->input('photos');
    // dd($photos);
    //access a request header
    $header = $request->header('X-header-Name'); //null if not
    //access bearerToken
    $token = $request->bearerToken();
    //pass default value to a input
    $input = $request->input('name', 'Nishanth');
    //dd($input);
    //access an input from an array
    $arrayInput = $request->input('array.0.name');
    //access query string
    $element = $request->query('id');
    //access JSON input values
    $jsonValue = $request->input('user.name');
    //Using onl A portion of the input data
    $input = $request->only(['id', 'photos']);
    $input = $request->except(['table']);
    //Determining If Input Is Present
    /*      //has(['val1','val2'])
            if ($request->has('id')) {
                return 'is there';
            }
       */
    /*
      The whenHas method will execute the given closure if a value is present on the request:
    $request->whenHas('id', function ($input) {
        return 'hi';
    });
    */
    //determine if a value is present and not empty
    $check = $request->filled('id');

    //Retriving Cookies from Requests

    $value = $request->cookie('name');
})->name('request.get');



Route::prefix('blog-post')->group(function () {
    Route::get('show-form', [PostController::class, 'showForm']);
});
