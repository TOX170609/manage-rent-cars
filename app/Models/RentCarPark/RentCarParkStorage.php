<?php

namespace App\Models\RentCarPark;

use Illuminate\Support\Facades\DB;

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
//    function setCar(string $brand, int $yearProduce, int $carMileage, string $color): string
//    {
    // TODO: Implement setCar() method.
//    }

    /**
     * @inheritDoc
     */
//    function list(bool $all, bool $active, bool $renovation, bool $rented): array
//    {
//        if($all){
//            return RentCar::all();
//        }
//    }

    /**
     * @inheritDoc
     */
//    function updateCar(int $id, int $carMileage, string $color, bool $active, bool $renovation, bool $rented): bool
//    {
//        // TODO: Implement updateCar() method.
//    }

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
//    function deleteCar(int $id): string
//    {
//        // TODO: Implement deleteCar() method.
//    }
}
