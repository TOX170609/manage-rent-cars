<?php
namespace App\Virtual;
/**
 * @OA\Schema(
 *     type="object",
 *     title="Удаление автомобиля из базы",
 *     description="Удаление автомобиля из базы по id машины",
 * )
 */
class DeleteCarRequest
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

}
