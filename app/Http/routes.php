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

    $width = 5;
    $height = 5;

    $offset = 10;

    $img->resize($width, $height);

    foreach(range(0, $width - 1) as $x) {
        foreach(range(0, $height - 1) as $y) {

            // Get the brightness from the pixel
            $rgb = $img->pickColor($x, $y, 'array');
            $brightness = \App\Helpers\Color::brightness($rgb);

            // Build a query to search for blocks within this brightness range
            $q = App\Block::whereBetween('brightness', [$brightness - $offset, $brightness + $offset]);

            // Use the difference in brightness for sorting
            $abs = sprintf('ABS(brightness - %s)', $brightness);
            $raw = DB::raw($abs);
            $q->select(['*', $raw]);
            $q->orderBy($raw);

            // Get the most resembling block
            $block = $q->first();

            $colors[] = $brightness . ' - ' . ($block ? $block->brightness : '...');
        }
    }

    return $colors;
});
