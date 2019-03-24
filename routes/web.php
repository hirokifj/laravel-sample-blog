<?php
use App\Post;

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

    $posts = Post::latest()->limit(9)->get();

    return view('welcome', ['posts' => $posts]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('posts', 'PostsController');
Route::post('/posts/{post}/comments', 'PostCommentsController@store')->name('comments.store');
