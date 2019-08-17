<?php
Route::get('robots.txt', function () {
    $robots = new  Cog\RobotsTxt\RobotsTxt;
    $robots->addUserAgent('*');
    $robots->addDisallow(config('definitions.ADMIN_FOLDER'));
    $robots->addDisallow('/rix-login');
    $robots->addSitemap(URL::to('/sitemap.xml'));
    return Response::make($robots->generate(), 200, array('Content-Type' => 'text/plain'));
});

Auth::routes();
Route::group(['prefix' => \App\Helpers\Helper::rixPrefix(),'as' => 'rix.', 'middleware' => ['accessibility', 'roles']], function () {
    Route::get('', 'Rix\RixController@get_rix')->name('home');
    // Gallery
    Route::get('gallery', 'Rix\GalleryController@get_gallery')->name('gallery');
    Route::post('gallery', 'Rix\GalleryController@get_gallery')->name('gallery');
    Route::delete('gallery', 'Rix\GalleryController@delete_image')->name('delete_image');

    // New Media
    Route::get('new_media', 'Rix\GalleryController@new_media')->name('new_media');
    Route::post('new_media', 'Rix\GalleryController@new_media')->name('add_new_media');
    // Update Media
    Route::post('update_media', 'Rix\GalleryController@update_media')->name('update_media');

    // Posts
    Route::get('posts', 'Rix\Posts\PostsController@get_posts')->name('posts');
    Route::post('posts', 'Rix\Posts\PostsController@get_posts')->name('posts');
    Route::delete('posts', 'Rix\Posts\PostsController@delete_post')->name('delete_post');
    Route::put('posts', 'Rix\Posts\PostsController@update_post')->name('update_post');

    // New Post
    Route::get('new_post', 'Rix\Posts\PostsController@new_post')->name('new_post');
    Route::post('new_post', 'Rix\Posts\PostsController@add_new_post')->name('add_new_post');
    // Update Post
    Route::get('post', 'Rix\Posts\PostsController@get_post')->name('post');
    Route::put('post', 'Rix\Posts\PostsController@update_post')->name('update_post');
    // Categories
    Route::get('categories', 'Rix\Posts\CategoriesController@get_categories')->name('categories');
    Route::post('categories', 'Rix\Posts\CategoriesController@new_category')->name('new_category');
    Route::delete('categories', 'Rix\Posts\CategoriesController@delete_category')->name('delete_category');
    Route::put('categories', 'Rix\Posts\CategoriesController@update_category')->name('update_category');
    // Tags
    Route::get('tags', 'Rix\Posts\TagsController@get_tags')->name('tags');
    Route::post('tags', 'Rix\Posts\TagsController@new_tag')->name('new_tag');
    Route::delete('tags', 'Rix\Posts\TagsController@delete_tags')->name('delete_tags');
    Route::put('tags', 'Rix\Posts\TagsController@update_tag')->name('update_tag');
    // Comments
    Route::get('comments', 'Rix\CommentsController@get_comments')->name('comments');
    Route::post('comments', 'Rix\CommentsController@action_comments')->name('action_comments');
    // Messages
    Route::get('messages', 'Rix\MessagesController@get_messages')->name('messages');
    Route::post('messages', 'Rix\MessagesController@action_messages')->name('action_messages');
    // Subscription
    Route::get('subscriptions', 'Rix\SubscriptionsController@get_subscriptions')->name('subscriptions');
    Route::post('subscriptions', 'Rix\SubscriptionsController@action_subscriptions')->name('action_subscriptions');
    Route::get('send_email_subscriptions', 'Rix\SubscriptionsController@get_send_email_subscriptions')->name('send_email_subscriptions');
    Route::post('send_email_subscriptions', 'Rix\SubscriptionsController@action_send_email_subscriptions')->name('action_send_email_subscriptions');
    // Users
    Route::get('users', 'Rix\UsersController@get_users')->name('users');
    Route::post('users', 'Rix\UsersController@action_users')->name('action_users');
    Route::get('user/{id?}', 'Rix\UsersController@get_user')->where('id', '^([0-9-]+)?')->name('user');
    Route::post('user', 'Rix\UsersController@action_user')->name('action_user');
    // Profile
    Route::get('profile', 'Rix\ProfileController@get_profile')->name('profile');
    Route::post('profile', 'Rix\ProfileController@update_profile')->name('update_profile');
    // Pages
    Route::get('pages', 'Rix\PagesController@get_pages')->name('pages');
    Route::post('pages', 'Rix\PagesController@action_pages')->name('action_pages');
    Route::get('page/{id?}', 'Rix\PagesController@get_page')->where('id', '^([0-9-]+)?')->name('page');
    Route::post('page', 'Rix\PagesController@action_page')->name('action_page');
    // Settings
    Route::group(['prefix' => 'settings','as' => 'settings.'], function () {
        Route::get('', 'Rix\SettingsController@get_settings')->name('setting');
        Route::any('general', 'Rix\SettingsController@get_setting')->name('general');
        Route::any('seo', 'Rix\SettingsController@get_setting')->name('seo');
        Route::any('email', 'Rix\SettingsController@get_setting')->name('email');
        Route::any('cache', 'Rix\SettingsController@get_setting')->name('cache');
        Route::any('security', 'Rix\SettingsController@get_setting')->name('security');
        Route::any('guide', 'Rix\SettingsController@get_setting')->name('guide');
    });
    Route::post('/preview_mail', function () {
        $items = (object)[
            'title'           => request()->input('subject'),
            'message'         => request()->input('message'),
        ];
        return new \App\Mail\Subscriptions($items, ['email' => 'test@gmail.com','security' => '#']);
    })->name('preview_mail');
    Route::post('/mark_notifications', 'Rix\NotificationsController@action_notifications')->name('mark_notifications');
});
Route::get('rix_actions','Rix\RixActions@get_action')->name('rix_actions');
Route::get('/rix-login', 'Rix\LoginController@get_login')->name('rix_login');
Route::post('/rix-login', 'Rix\LoginController@action_login')->name('rix_action_login');
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('welcome');
})->name('rix_logout');
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/home', 'HomeController@index')->name('home');