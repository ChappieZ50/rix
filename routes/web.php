<?php
Route::get('robots.txt', function() {
    $robots = new  Cog\RobotsTxt\RobotsTxt;
    $robots->addUserAgent('*');
    $robots->addDisallow(config('definitions.ADMIN_FOLDER'));
    return Response::make($robots->generate(), 200, array('Content-Type' => 'text/plain'));
});

Route::group(['prefix' => config('definitions.ADMIN_FOLDER').'/'],function(){
    Route::get('', 'Rix\RixController@get_rix')->name('rix_home');
});

Route::get('/', function () {
    return view('welcome');
});

