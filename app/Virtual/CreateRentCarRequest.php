<?php
namespace App\Virtual;
/**
 * @OA\Schema(
 *     type="object",
 *     title="Добавление нового автомобиля",
 *     description="Запрос создающий новый автомобиль в базе данных парка",
 * )
 */
class CreateRentCarRequest
{
    /**
     * @OA\Property(
     *     title="Brand",
     *     description="Machine brand",
     *     format="string",
     *     example="Volvo",
     * )
     *
     * @var string
     */
    public $brand;

    /**
     * @OA\Property(
     *     title="Production year",
     *     description="Production year",
     *     format="int64",
     *     example="2022",
     * )
     *
     * @var int
     */
    public $yearProduce;

    /**
     * @OA\Property(
     *     title="Car mileage",
     *     description="Car mileage",
     *     format="int64",
     *     example="19000",
     * )
     *
     * @var int
     */

    public $carMileage;

    /**
     * @OA\Property(
     *     title="Color",
     *     description="Car`s color",
     *     format="string",
     *     example="yellow",
     * )
     *
     * @var string
     */
    public $color;

}
