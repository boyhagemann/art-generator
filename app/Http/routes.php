<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('search/{q}', function($q) {

    $helper = new App\Helpers\Flickr();

    $photos = $helper->search($q);

    return $photos;
});

Route::get('image', function() {

    $file = storage_path('flower1.jpg');

    /** @var Intervention\Image\Image $img */
    $img = Image::make($file);
    var_dump($img->pickColor(0,0, 'hex'));

    $width = 10;
    $height = 10;
    $img->resize($width,$height);




    dd($img->pickColor(0,0, 'hex'));
});


/**
 *
s	small square 75x75
q	large square 150x150
t	thumbnail, 100 on longest side
m	small, 240 on longest side
n	small, 320 on longest side
-	medium, 500 on longest side
z	medium 640, 640 on longest side
c	medium 800, 800 on longest side†
b	large, 1024 on longest side*
h	large 1600, 1600 on longest side†
k	large 2048, 2048 on longest side†
o	original image, either a jpg, gif or png, depending on source format

 */