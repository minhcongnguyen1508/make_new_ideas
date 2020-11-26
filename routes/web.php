<?php

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


// Route::get('/', 'Controller@index');
Route::get('/', 'Frontend\HomepageController@index')->name('homepage');

Route::get('/story/{id}', 'Frontend\StoryController@index')->name('story')->middleware('auth');

Route::post('/comment/{id}', 'Frontend\CommentController@store')->name('comment.create');
Route::post('like_cmt/{comment_id}', 'Frontend\CommentController@like');
Route::post('unlike_cmt/{comment_id}', 'Frontend\CommentController@unLike');
Route::get('count_like_cmt/{comment_id}', 'Frontend\CommentController@countLike');
Route::get('count_unlike_cmt/{comment_id}', 'Frontend\CommentController@countUnLike');
Route::get('get_status_like_cmt/{comment_id}', 'Frontend\CommentController@statusLike');

Route::get('/signin', 'Auth\AuthController@signin')->name('signin');

Route::get('/signup', 'Auth\AuthController@signup')->name('signup');

Route::post('post-login', 'Auth\AuthController@postLogin');
Route::post('post-register', 'Auth\AuthController@postRegister');

Route::get('home', 'Auth\AuthController@home');
Route::get('logout', 'Auth\AuthController@logout');


Route::get('livesearch', 'LiveSearch@action')->name('live_search');

Route::get('like/{post_id}', 'Frontend\StoryController@like');
Route::get('unlike/{post_id}', 'Frontend\StoryController@unLike');
Route::get('count-like/{post_id}', 'Frontend\StoryController@countLike');
Route::get('get-status-like/{post_id}', 'Frontend\StoryController@statusLike');
Route::get('/auth/{provider}', 'Auth\SocialAuthController@redirectToProvider');
Route::get('/auth/{provide}/callback', 'Auth\SocialAuthController@handleProviderCallback');
Route::get('create-story', 'Frontend\StoryController@showCreateStory');
Route::post('post-story','Frontend\StoryController@createStory');


Route::get('/profile/{id}', 'Frontend\UserController@show')->name('user.show');
Route::post('/profile/{id}', 'Frontend\UserController@edit')->name('user.edit');
Route::post('/follow/{writer_id}', 'Frontend\FollowController@follow')->name('follow');
Route::delete('/unfollow/{writer_id}', 'Frontend\FollowController@unfollow')->name('unfollow');
Route::get('/isfollowed/{writer_id}', 'Frontend\FollowController@isFollowed')->name('isfollowed');

Route::get('/reading-list','Frontend\ReadingListController@index')->name('reading-list');
Route::get('status-save/{post_id}','Frontend\ReadingListController@statusSave');
Route::get('save/{post_id}', 'Frontend\ReadingListController@save');
Route::get('unsave/{post_id}', 'Frontend\ReadingListController@unsave');

Route::get('remove/{post_id}', 'Frontend\ReadingListController@remove');

Route::get('/search', 'Frontend\SearchController@getSearch')->name('search');

