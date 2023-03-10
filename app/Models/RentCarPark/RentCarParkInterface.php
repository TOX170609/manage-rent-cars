<?php

namespace App\Models\RentCarPark;

use Illuminate\Database\Eloquent\Collection;

interface RentCarParkInterface
{
    /**
     * Возвращает уникальный идентификатор пользователя
     * @return object
     */
    function getUserId(string $email): object;

    /**
     * Занесение автомобиля в базу данных, возвращает сообщение об успешной или неуспешной операции добавления
     * @param string $brand
     * @param int $yearProduce
     * @param int $carMileage
     * @param string $color
     * @return object
     */
    function setCar(string $brand, int $yearProduce, int $carMileage, string $color): object;

    /**
     * Получение списка автомобилей, с возможностью выборки по состоянию автомобиля
     * (готов к аренде, в ремонте, уже в аренде)
     * @param bool $all
     * @param int $param_id
     * @return Collection
     */
    function list(bool $all, int $param_id): Collection;

    /**
     * Возвращает сообщение об успешной или неуспешной операции обновления
     * @param int $id
     * @param string $color
     * @param bool $active
     * @param bool $renovation
     * @param bool $rented
     * @param int|null $driverID
     * @return object
     */
    function updateCar(int $id, string $color, bool $active, bool $renovation, bool $rented, ?int $driverID): object;

    /**
     * Возвращает объект содержащий информацию об автомобиле
     * @param int $id
     * @return object
     */
    function getInfo(int $id): object;

    /**
     * Удаляет автомобиль из базы
     * @param int $id
     * @return object
     */
    function deleteCar(int $id): object;

}
