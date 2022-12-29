<?php

namespace App\Http\Controllers\RentCarPark;

use App\Http\Controllers\Controller;
use App\Models\RentCarPark\RentCar;
use App\Models\RentCarPark\RentCarParkStorage;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RentCarPark extends Controller
{
    /**
     * @var Request
     */
    private Request $request;
    private RentCarParkStorage $carPark;

    public function __construct(Request $request, RentCarParkStorage $carPark)
    {
        $this->request = $request;
        $this->carPark = $carPark;
    }

    /**
     * @OA\Post(
     *     path="/setCar",
     *     operationId="rentCarCreate",
     *     tags={"RentCarPark"},
     *     summary="Создает новый автомобиль",
     *     security={
     *       {"administratorKey": {}},
     *     },
     *    @OA\Response(
     *         response="201",
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/CreateRentCarRequest")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad request",
     *     ),
     *      @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(ref="#/components/schemas/CreateRentCarRequest")
     *     )
     * )
     * Добавление нового автомобиля в базу данных
     * @return object
     */
    public function setCar(Request $request): object
    {
        $apiKey = $this->request->server->all();

        if(!array_key_exists('HTTP_ADMINISTRATORKEY', $apiKey) || $apiKey['HTTP_ADMINISTRATORKEY'] != 'admin'){
            return response('Вы не являетесь администратором, авторизуйтесь', 401);
        }

        if(empty($request['brand'])) {
            return response('Не передана марка автомобиля', 400);
        }
        return $this->carPark->setCar($request['brand'], (integer)$request['yearProduce'], (integer)$request['carMileage'], $request['color']);
    }


    /**
     * @OA\Get(
     *     path="/getCar",
     *     operationId="getCar",
     *     tags={"RentCarPark"},
     *     summary="Возвращает информацию о машине",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id автомобиля",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Запрос обработан успешно",
     *     ),
     *      @OA\Response(
     *         response="400",
     *         description="Переданы неверные данные",
     *     ),
     * )
     *
     * Возвращает информацию о машине
     * @return object
     */
    public function getInfo(Request $request): object
    {
        return $this->carPark->getInfo((integer)$request['id']);
    }


    /**
     * @OA\Get(
     *     path="/getCarPark",
     *     operationId="getCarPark",
     *     tags={"RentCarPark"},
     *     summary="Возвращает информацию о машинах",
     *     @OA\Parameter(
     *         name="all",
     *         in="query",
     *         description="
    true - если вывести все машины
    false - если вывести по параметрам отбора
    ",
     *         required=true,
     *         example="true",
     *         @OA\Schema(
     *             type="string",
     *         ),
     *     ),
     *      @OA\Parameter(
     *         name="param_id",
     *         in="query",
     *         description="
    1 - только активные машины
    2 - только машины находящиеся в ремонте
    3 - только арендованные машины
    ",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Запрос обработан успешно",
     *     ),
     *      @OA\Response(
     *         response="400",
     *         description="Переданы неверные данные",
     *     ),
     * )
     * Получение списка автомобилей, с возможностью выборки по состоянию автомобиля
     * (готов к аренде, в ремонте, уже в аренде)
     * @return object
     */
    public function list(Request $request): object
    {
        if ($request['all'] == 'true') {
            return $this->carPark->list(true, false);
        } else {
            $result = $this->carPark->list(false, $request['param_id']);
            if (!$result->isEmpty()) {
                return (object)$result;
            } else {
                return response('По вашему запросу не найдено автомобилей', 404);
            }
        }
    }


    /**
     * @OA\Put(
     *     path="/updateCar",
     *     operationId="rentCarUpdate",
     *     tags={"RentCarPark"},
     *     summary="Обновляет данные об автомобиле",
     *     security={
     *       {"administratorKey": {}},
     *     },
     *    @OA\Response(
     *         response="200",
     *         description="Обновление данных прошло успешно",
     *         @OA\JsonContent(ref="#/components/schemas/UpdateRentCarRequest")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Переданы неверные данные",
     *     ),
     *      @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateRentCarRequest")
     *     )
     * )
     * Обновление данных об автомобиле
     * @return object
     */
    public function updateCar(Request $request): object
    {
        $apiKey = $this->request->server->all();
        if(!array_key_exists('HTTP_ADMINISTRATORKEY', $apiKey) || $apiKey['HTTP_ADMINISTRATORKEY'] != 'admin'){
            return response('Вы не являетесь администратором, авторизуйтесь', 401);
        }

        $user = $request['driverEmail'] == 'false' ? true : $this->carPark->getUserId($request['driverEmail']);
        if (!$user && $request['driverEmail'] != 'false') {
            return response('Указан неверный email водителя', 400);
        }

        $driverID = $request['driverEmail'] == 'false' ? null : $user['id'];
        $active = $request['active'] == 'true';
        $renovation = $request['renovation'] == 'true';
        $rented = $request['rented'] == 'true';

        return $this->carPark->updateCar((integer)$request['id'], $request['color'], $active, $renovation, $rented, $driverID);

    }


    /**
     * @OA\Post(
     *     path="/deleteCar",
     *     operationId="deleteCar",
     *     tags={"RentCarPark"},
     *     summary="Удаление автомобиля из базы",
     *      security={
     *       {"administratorKey": {}},
     *     },
     *     @OA\Response(
     *         response="200",
     *         description="Удаление автомобиля из базы прошло успешно",
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Удаление автомобиля из базы прошло не успешно",
     *     ),
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/DeleteCarRequest")
     *     )
     * )
     *
     * Удаление машины из базы данных
     * @return object
     */
    public function deleteCar(Request $request): object
    {
        $apiKey = $this->request->server->all();
        if(!array_key_exists('HTTP_ADMINISTRATORKEY', $apiKey) || $apiKey['HTTP_ADMINISTRATORKEY'] != 'admin'){
            return response('Вы не являетесь администратором, авторизуйтесь', 401);
        }

        return $this->carPark->deleteCar((integer)$request['id']);

    }
}
