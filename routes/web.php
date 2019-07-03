<?php
Route::get('robots.txt', function () {
    $robots = new  Cog\RobotsTxt\RobotsTxt;
    $robots->addUserAgent('*');
    $robots->addDisallow(config('definitions.ADMIN_FOLDER'));
    $robots->addDisallow('/rix-login');
    return Response::make($robots->generate(), 200, array( 'Content-Type' => 'text/plain' ));
});
Auth::routes();
Route::group([ 'prefix' => config('definitions.ADMIN_FOLDER') . '/', 'middleware' => [ 'accessibility', 'roles' ] ], function () {
    Route::get('', 'Rix\RixController@get_rix')->name('rix_home');
    // Gallery
    Route::get('gallery', 'Rix\GalleryController@get_gallery')->name('rix_gallery');
    Route::post('gallery', 'Rix\GalleryController@get_gallery')->name('rix_gallery');
    Route::delete('gallery', 'Rix\GalleryController@delete_image')->name('rix_delete_image');

    // New Media
    Route::get('new_media', 'Rix\GalleryController@new_media')->name('rix_new_media');
    Route::post('new_media', 'Rix\GalleryController@new_media')->name('rix_add_new_media');
    // Update Media
    Route::post('update_media', 'Rix\GalleryController@update_media')->name('rix_update_media');

    // Posts
    Route::get('posts', 'Rix\Posts\PostsController@get_posts')->name('rix_posts');
    Route::post('posts', 'Rix\Posts\PostsController@get_posts')->name('rix_posts');
    Route::delete('posts', 'Rix\Posts\PostsController@delete_post')->name('rix_delete_post');
    Route::put('posts', 'Rix\Posts\PostsController@update_post')->name('rix_update_post');

    // New Post
    Route::get('new_post', 'Rix\Posts\PostsController@new_post')->name('rix_new_post');
    Route::post('new_post', 'Rix\Posts\PostsController@add_new_post')->name('rix_add_new_post');
    // Update Post
    Route::get('post', 'Rix\Posts\PostsController@get_post')->name('rix_post');
    Route::put('post', 'Rix\Posts\PostsController@update_post')->name('rix_update_post');
    // Categories
    Route::get('categories', 'Rix\Posts\CategoriesController@get_categories')->name('rix_categories');
    Route::post('categories', 'Rix\Posts\CategoriesController@new_category')->name('rix_new_category');
    Route::delete('categories', 'Rix\Posts\CategoriesController@delete_category')->name('rix_delete_category');
    Route::put('categories', 'Rix\Posts\CategoriesController@update_category')->name('rix_update_category');
    // Tags
    Route::get('tags', 'Rix\Posts\TagsController@get_tags')->name('rix_tags');
    Route::post('tags', 'Rix\Posts\TagsController@new_tag')->name('rix_new_tag');
    Route::delete('tags', 'Rix\Posts\TagsController@delete_tags')->name('rix_delete_tags');
    Route::put('tags', 'Rix\Posts\TagsController@update_tag')->name('rix_update_tag');
    // Comments
    Route::get('comments', 'Rix\CommentsController@get_comments')->name('rix_comments');
    Route::post('comments', 'Rix\CommentsController@action_comments')->name('rix_action_comments');
    // Messages
    Route::get('messages', 'Rix\MessagesController@get_messages')->name('rix_messages');
    Route::post('messages', 'Rix\MessagesController@action_messages')->name('rix_action_messages');
    // Subscription
    Route::get('subscriptions', 'Rix\SubscriptionsController@get_subscriptions')->name('rix_subscriptions');
    Route::post('subscriptions', 'Rix\SubscriptionsController@action_subscriptions')->name('rix_action_subscriptions');
    // Users
    Route::get('users', 'Rix\UsersController@get_users')->name('rix_users');
    Route::post('users', 'Rix\UsersController@action_users')->name('rix_action_users');
    Route::get('user/{id?}', 'Rix\UsersController@get_user')->where('id', '^([0-9-]+)?')->name('rix_user');
    Route::post('user', 'Rix\UsersController@action_user')->name('rix_action_user');
    // Profile
    Route::get('profile', 'Rix\ProfileController@get_profile')->name('rix_profile');
    Route::post('profile', 'Rix\ProfileController@update_profile')->name('rix_update_profile');
    // Pages
    Route::get('pages', 'Rix\PagesController@get_pages')->name('rix_pages');
    Route::post('pages', 'Rix\PagesController@action_pages')->name('rix_action_pages');
    Route::get('page/{id?}', 'Rix\PagesController@get_page')->where('id', '^([0-9-]+)?')->name('rix_page');
    Route::post('page', 'Rix\PagesController@action_page')->name('rix_action_page');
    // Settings
    Route::group([ 'prefix' => 'settings' ], function () {
        Route::get('', 'Rix\SettingsController@get_settings')->name('rix_settings');
        Route::any('general', 'Rix\SettingsController@get_setting')->name('rix_settings_general');
        Route::any('seo', 'Rix\SettingsController@get_setting')->name('rix_settings_seo');
        Route::any('email', 'Rix\SettingsController@get_setting')->name('rix_settings_email');
        Route::any('cache', 'Rix\SettingsController@get_setting')->name('rix_settings_cache');
        Route::any('security', 'Rix\SettingsController@get_setting')->name('rix_settings_security');
        Route::any('other', 'Rix\SettingsController@get_setting')->name('rix_settings_other');
    });
});
Route::get('/rix-login', 'Rix\LoginController@get_login')->name('rix_login');
Route::post('/rix-login', 'Rix\LoginController@action_login')->name('rix_action_login');
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('welcome');
})->name('rix_logout');
Route::get('/', function () {
    return view('welcome');
})->name('welcome');