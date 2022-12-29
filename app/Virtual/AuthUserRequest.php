<?php
namespace App\Virtual;
/**
 * @OA\Schema(
 *     type="object",
 *     title="Авторизация",
 *     description="Авторизация пользователя",
 * )
 */
class AuthUserRequest
{
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
