<?php

use App\Http\Controllers\RentCarPark\AuthController;
use App\Http\Controllers\RentCarPark\RentCarPark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Все запросы касающиеся автомобиля
Route::post('/setCar', [RentCarPark::class, 'setCar']);
Route::get('/getCar', [RentCarPark::class, 'getInfo']);
Route::get('/getCarPark', [RentCarPark::class, 'list']);
Route::put('/updateCar', [RentCarPark::class, 'updateCar']);
Route::post('/deleteCar', [RentCarPark::class, 'deleteCar']);

//Все запросы касающиеся регистрации и авторизации
Route::post('/registration', [AuthController::class, 'registration']);
Route::post('/auth', [AuthController::class, 'auth']);
Route::post('/logout', [AuthController::class, 'logout']);




