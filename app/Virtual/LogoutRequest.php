<?php
namespace App\Virtual;
/**
 * @OA\Schema(
 *     type="object",
 *     title="Разлогинивание",
 *     description="Выход из аккаунта",
 * )
 */
class LogoutRequest
{
    /**
     * @OA\Property(
     *     title="email",
     *     description="user's email",
     *     format="string",
     *     example="Test@mail.ru",
     * )
     *
     * @var string
     */
    public $email;

}
