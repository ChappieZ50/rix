<?php
Route::get('robots.txt', function() {
    $robots = new  Cog\RobotsTxt\RobotsTxt;
    $robots->addUserAgent('*');
    $robots->addDisallow(config('definitions.ADMIN_FOLDER'));
    return Response::make($robots->generate(), 200, array('Content-Type' => 'text/plain'));
});

Route::group(['prefix' => config('definitions.ADMIN_FOLDER').'/'],function(){
    Route::get('', 'Rix\RixController@get_rix')->name('rix_home');

    // Gallery
    Route::get('gallery','Rix\GalleryController@get_gallery')->name('rix_gallery');
    Route::post('gallery','Rix\GalleryController@get_gallery')->name('rix_gallery');
    Route::delete('gallery','Rix\GalleryController@delete_image')->name('rix_delete_image');

    // New Media
    Route::get('new_media','Rix\GalleryController@new_media')->name('rix_new_media');
    Route::post('new_media','Rix\GalleryController@new_media')->name('rix_add_new_media');
    // Update Media
    Route::post('update_media','Rix\GalleryController@update_media')->name('rix_update_media');

    // Posts
    Route::get('posts','Rix\BlogController@get_posts')->name('rix_posts');

    // New Post
    Route::get('new_post','Rix\BlogController@new_post')->name('rix_new_post');
    Route::post('new_post','Rix\BlogController@add_new_post')->name('rix_add_new_post');
});

Route::get('/', function () {
    return view('welcome');
});

