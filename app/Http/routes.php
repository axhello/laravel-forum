<?php

//\Auth::loginUsingId(2);
Route::group(['middleware' => 'web'], function () {
//    Route::auth();
    Route::get('/user/register', 'UsersController@register');
    Route::get('/user/login', 'UsersController@login');
    Route::post('/user/register', 'UsersController@create');
    Route::post('/user/login', 'UsersController@signin');
    Route::get('/user/logout', 'UsersController@logout');
    Route::get('/password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('/password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'Auth\PasswordController@reset');
    Route::get('/password/change', 'PasswordController@change');
    Route::post('/password/change', 'PasswordController@changePass');
    Route::get('/verify/{confirm_code}', 'UsersController@confirmEmail');

    Route::resource('/discuss', 'PostController');
    Route::resource('/favorite', 'FavoriteController');
    Route::post('/likes/votes', 'LikesController@store');
    Route::post('/likes/cancel', 'LikesController@destroy');

    Route::get('/', 'PostController@index');
    Route::get('/captcha', 'UsersController@captcha');
    Route::get('/auth/github', 'UsersController@redirectToProvider');
    Route::get('/github/login', 'UsersController@handleProviderCallback');
    Route::get('/search', 'SearchController@search');
    Route::get('/user/profile', 'UsersController@profile');
    Route::get('/user/account', 'UsersController@account');
    Route::get('/user/favorites', 'FavoriteController@favorites');
    Route::get('/discuss/tags/{tag}', 'TagsController@show');

    Route::post('/user/account', 'UsersController@saveInfo');
    Route::post('/user/avatar', 'UsersController@changeAvatar');
    Route::post('/crop/api', 'UsersController@cropAvatar');
    Route::post('/post/upload', 'PostController@upload');
    Route::post('/comment/image', 'CommentsController@upload');
    Route::post('/discuss/{id}/replies', 'CommentsController@store');
    Route::get('/user/{name}', 'UsersController@information');
});
