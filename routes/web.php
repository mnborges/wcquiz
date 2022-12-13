<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/quiz', function () {
    $questions = array(
        1 => [
            "sentence" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
            "alternatives" => [
                "1" => "Lorem ipsum dolor",
                "2" => "sit amet, consectetur adipiscing elit",
                "3" => "sed do eiusmod tempor incididunt",
            ]

        ],
        2 => [
            "sentence" => "Urna nec tincidunt praesent semper feugiat nibh sed pulvinar. Mauris a diam maecenas sed enim ut sem viverra aliquet.",
            "alternatives" => [
                "1" => "Viverra justo nec ultrices",
                "2" => "Senectus et netus et malesuada fames ac",
                "3" => "Odio pellentesque diam",
            ]

        ],
        3 => [
            "sentence" => "Mi eget mauris pharetra et ultrices neque ornare aenean euismod.",
            "alternatives" => [
                "1" => "Enim nunc faucibus a pellentesque",
                "2" => "Euismod nisi porta lorem mollis aliquam ut porttitor",
                "3" => "Odio eu feugiat pretium nibh",
            ]

        ]
    );
    return view('question', ["questions" => $questions]);
});

Route::resource('/', QuestionController::class)->only(['index']);

use Illuminate\Http\Request;

// temporary route to view form data
Route::post('/quiz', function (Request $request) {
    $input = $request->all();
    return response($input);
});