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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/quiz', function () {
    $questions = array(
            1 =>[
                "main" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                "answers" => [
                    "1" => "Lorem ipsum dolor",
                    "2" => "sit amet, consectetur adipiscing elit",
                    "3" => "sed do eiusmod tempor incididunt",
                ]
                    
            ],
            2 =>[
                "main" => "Urna nec tincidunt praesent semper feugiat nibh sed pulvinar. Mauris a diam maecenas sed enim ut sem viverra aliquet.",
                "answers" => [
                    "1" => "Viverra justo nec ultrices",
                    "2" => "Senectus et netus et malesuada fames ac",
                    "3" => "Odio pellentesque diam",
                ]
                    
                ],
            3 =>[
                "main" => "Mi eget mauris pharetra et ultrices neque ornare aenean euismod.",
                "answers" => [
                    "1" => "Enim nunc faucibus a pellentesque",
                    "2" => "Euismod nisi porta lorem mollis aliquam ut porttitor",
                    "3" => "Odio eu feugiat pretium nibh",
                ]
                    
            ]
        );
    return view('question', ["questions"=>$questions]);
});
