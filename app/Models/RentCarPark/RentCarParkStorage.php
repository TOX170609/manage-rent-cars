<?php

namespace App\Models\RentCarPark;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class RentCarParkStorage implements RentCarParkInterface
{

    /**
     * @inheritDoc
     */
//    function getUserId(): int
//    {
//        // TODO: Implement getUserId() method.
//    }

    /**
     * @inheritDoc
     */
    function setCar(string $brand, int $yearProduce, int $carMileage, string $color): string
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
            return 'Сохранение прошло успешно';
        }
        return 'Не удалось добавить новый автомобиль';

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
                2 => RentCar::all()->where('renovation', true),
                3 => RentCar::all()->where('rented', true),
            };
        }
    }

    /**
     * @inheritDoc
     */
    function updateCar(int $id, string $color, bool $active, bool $renovation, bool $rented, int $driverID): string
    {

        $issetDriver = DB::table('rent_cars')->where('driverID', $driverID);

        if($issetDriver){
            return 'У данного водителя уже есть арендованный автомобиль';
        }

        DB::table('rent_cars')
            ->where('id', $id)
            ->update([
                'color' => $color,
                'active' => $active,
                'renovation' => $renovation,
                'rented' => $rented,
                'driverID' => $driverID
            ]);
        return 'Обновление данных об автомобиле прошло успешно!';
    }

    /**
     * @inheritDoc
     */
    function getInfo(int $id): object
    {
        return DB::table('rent_cars')->find($id);
    }

    /**
     * @inheritDoc
     */
    function deleteCar(int $id): string
    {
        $deleted = DB::table('rent_cars')->where('id', '=', $id)->delete();

        if ($deleted) {
            return 'Удаление прошло успешно';
        }
        return 'Удаление прошло не успешно';
    }
}
