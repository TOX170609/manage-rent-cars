<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Регистрация нового пользователя
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function registration(Request $request)
    {
        try {
            $fields = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|unique:App\Models\User,email',
                'password' => 'required|string',
            ]);

            $newUser = new User();
            $newUser->name = $fields['name'];
            $newUser->email = $fields['email'];
            $newUser->password = Hash::make($fields['password']);

            $newUser->save();

            $token = $newUser->createToken('api-access', [])->plainTextToken;

            $response = [
                'token' => $token,
                'user' => [
                    'email' => $newUser->email,
                ],
            ];

            return response($response, 201);
        } catch (Exception $ex) {
            return response($ex->getMessage(), 422);
        }
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function Auth(Request $request)
    {
        try {
            $fields = $request->validate([
                'email' => 'required|string',
                'password' => 'required|string',
            ]);
            $user = User::all()->where('email', $fields['email'])->first();

            if (!$user || !Hash::check($fields['password'], $user->password)) {
                return response(
                    ['message' => 'Неправильный логин или пароль'],
                    401
                );
            }

            $token = $user->createToken('api-access', [])->plainTextToken;
            $response = [
                'token' => $token,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ];
            return response($response, 201);
        } catch (ValidationException $ex) {
            return response($ex->getMessage(), 422);
        }
    }

    /**
     * Разлогинивание пользователя
     * @param Request $request
     * @return string[]
     */
    public function logout(Request $request)
    {
        $user = User::all()->where('email', $request['email'])->first();
        $user->tokens()->delete();
        return [
            'message' => 'Вы были успешно разлогинены',
        ];
    }
}
