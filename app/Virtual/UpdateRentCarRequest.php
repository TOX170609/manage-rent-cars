<?php
namespace App\Virtual;
/**
 * @OA\Schema(
 *     type="object",
 *     title="Обновление информации",
 *     description="Запрос обновляющий данные об автомобиле в том числе если машина сдается в аренду",
 * )
 */
class UpdateRentCarRequest
{
    /**
     * @OA\Property(
     *     title="id",
     *     description="id car",
     *     format="int64",
     *     example="1",
     * )
     *
     * @var int
     */
    public $id;

    /**
     * @OA\Property(
     *     title="color",
     *     description="color of car",
     *     format="string",
     *     example="grey",
     * )
     *
     * @var string
     */
    public $color;

    /**
     * @OA\Property(
     *     title="Active",
     *     description="All cars wich available to rent",
     *     format="string",
     *     example="true",
     * )
     *
     * @var string
     */

    public $active;

    /**
     * @OA\Property(
     *     title="Renovation",
     *     description="All cars wich have been repairing",
     *     format="string",
     *     example="false",
     * )
     *
     * @var string
     */

    public $renovation;

    /**
     * @OA\Property(
     *     title="Rented",
     *     description="All cars wich rented",
     *     format="string",
     *     example="true",
     * )
     *
     * @var string
     */

    public $rented;

    /**
     * @OA\Property(
     *     title="DriverEmail",
     *     description="Account driver wich rented car or false",
     *     format="string",
     *     example="false",
     * )
     *
     * @var string
     */

    public $driverEmail;



}
