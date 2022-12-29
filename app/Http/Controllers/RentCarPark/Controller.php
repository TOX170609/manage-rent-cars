<?php

namespace App\Http\Controllers\RentCarPark;

/**
 * @OA\Info(
 *     title="Fondarium competency test",
 *     version="1.0.0",
 *     @OA\Contact(
 *         email="admin@example.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\Tag(
 *      name="Registration and authtarization",
 *      description="Запросы управляющие пользователями сервиса",
 * )
 * @OA\Tag(
 *      name="RentCarPark",
 *      description="Запросы управляющие автомобилями",
 * )
 * @OA\Server(
 *     description="Laravel Swagger API server",
 *     url="http://localhost/api"
 * )
 *
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     in="header",
 *     name="administratorKey",
 *     securityScheme="administratorKey"
 * )
 *
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     in="header",
 *     name="userToken",
 *     securityScheme="userToken"
 * )
 */

class Controller extends \App\Http\Controllers\Controller
{

}
