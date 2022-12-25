<?php

use App\Http\Controllers\RentCarPark\RentCarPark;
use App\Http\Controllers\TestPage;
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

Route::get('/setCar', [RentCarPark::class, 'setCar']);

Route::get('/getCar', [RentCarPark::class, 'getInfo']);

Route::get('/getCarPark', [RentCarPark::class, 'list']);

Route::get('/updateCar', [RentCarPark::class, 'updateCar']);

Route::get('/deleteCar', [RentCarPark::class, 'deleteCar']);
