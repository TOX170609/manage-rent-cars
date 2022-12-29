<?php
namespace App\Virtual;
/**
 * @OA\Schema(
 *     type="object",
 *     title="Регистрация",
 *     description="Создание нового аккаунта в системе",
 * )
 */
class RegNewUserRequest
{
    /**
     * @OA\Property(
     *     title="Name",
     *     description="User's name",
     *     format="string",
     *     example="Петр",
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *     title="Email",
     *     description="User's email",
     *     format="string",
     *     example="Test@mail.ru",
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *     title="Password",
     *     description="Account's password",
     *     format="string",
     * )
     *
     * @var string
     */

    public $password;

}
