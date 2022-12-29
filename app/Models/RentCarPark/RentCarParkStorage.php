<?php

namespace App\Models\RentCarPark;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class RentCarParkStorage implements RentCarParkInterface
{

    /**
     * @inheritDoc
     */
    function getUserId($email): object
    {
        return User::all()->where('email', $email)->first();
    }

    /**
     * @inheritDoc
     */
    function setCar(string $brand, int $yearProduce, int $carMileage, string $color): object
    {
        $rentCar = new RentCar();
        $rentCar->brand = $brand;
        $rentCar->yearProduce = $yearProduce;
        $rentCar->carMileage = $carMileage;
        $rentCar->color = $color;
        $rentCar->active = true;
        $rentCar->renovation = false;
        $rentCar->rented = false;
        if ($rentCar->save()) {
            return response('Сохранение прошло успешно', 201);
        }
        return response('Не удалось добавить новый автомобиль', 400);

    }

    /**
     * @inheritDoc
     */
    function list(bool $all, int $param_id): Collection
    {
        if ($all) {
            return RentCar::all();
        } else {
            return match ($param_id) {
                1 => RentCar::all()->where('active', true),
                2 => RentCar::all()->where('renovation',true),
                3 => RentCar::all()->where('rented', true),
            };
        }
    }

    /**
     * @inheritDoc
     */
    function updateCar(int $id, string $color, bool $active, bool $renovation, bool $rented, ?int $driverID): object
    {
        if (!is_null($driverID)) {
            $issetDriver = RentCar::all()->where('driverID', $driverID)->first();
            if (!empty($issetDriver)) {
                return response('У данного водителя уже есть арендованный автомобиль', 400);
            }
        }
        $update = DB::table('rent_cars')
            ->where('id', $id)
            ->update([
                'color' => $color,
                'active' => $active,
                'renovation' => $renovation,
                'rented' => $rented,
                'driverID' => $driverID
            ]);

        if (!$update) {
            return response('Не верно указан id автомобиля', 400);
        }
        return response('Обновление данных об автомобиле прошло успешно!', 200);
    }

    /**
     * @inheritDoc
     */
    function getInfo(int $id): object
    {
        $getCar = DB::table('rent_cars')->find($id);
        if (!is_null($getCar)) {
            return $getCar;
        }
        return response('Автомобиля с таким ID нет, попробуйте другой!', 404);
    }

    /**
     * @inheritDoc
     */
    function deleteCar(int $id): object
    {

        $carInfo = RentCar::all()->where('id', $id)->where('rented', true)->first();

        if($carInfo){
            return response('Удаление невозможно, так как автомобиль находиться в аренде', 400);
        }

        $deleted = DB::table('rent_cars')->where('id', $id)->delete();

        if ($deleted) {
            return response('Удаление прошло успешно', 200);
        }
        return response('Удаление прошло не успешно', 400);
    }
}
