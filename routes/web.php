<?php
use App\Post;
use App\PostTag;

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
    $tags = PostTag::has('posts')->get();

    return view('welcome', compact('posts', 'tags'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('posts', 'PostsController');

Route::post('/posts/{post}/comments', 'PostCommentsController@store')->name('comments.store');

Route::get('/tags/{tag}', 'PostTagsController@list')->name('tags.list');
