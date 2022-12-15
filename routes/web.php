<?php

use App\Http\Controllers\ComputeResult;
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

// Register routes to GET and POST methods to '/'
Route::resource('/', QuestionController::class)->only(['index']);
Route::post('/', ComputeResult::class); 