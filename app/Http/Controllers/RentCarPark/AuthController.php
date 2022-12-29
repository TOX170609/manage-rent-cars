<?php

namespace App\Http\Controllers\RentCarPark;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use function response;

class AuthController extends Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @OA\Post(
     *     path="/registration",
     *     operationId="registration",
     *     tags={"Registration and authtarization"},
     *     summary="Регистрация нового пользователя",
     *    @OA\Response(
     *         response="201",
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/RegNewUserRequest")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad request",
     *     ),
     *      @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(ref="#/components/schemas/RegNewUserRequest")
     *     )
     * )
     * Регистрация нового пользователя
     * @param CreateUserRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function registration(CreateUserRequest $request)
    {
        try {
//            $fields = $request->validate([
//                'name' => 'required|string',
//                'email' => 'required|string|unique:App\Models\User,email',
//                'password' => 'required|string',
//            ]);

            $newUser = new User();
            $newUser->name = $request['name'];
            $newUser->email = $request['email'];
            $newUser->password = Hash::make($request['password']);

            $newUser->save();

            $newUser->createToken('api-access', [])->plainTextToken;

            $response = [
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
     *  * @OA\Post(
     *     path="/auth",
     *     operationId="authtarization",
     *     tags={"Registration and authtarization"},
     *     summary="Авторизация пользователя",
     *    @OA\Response(
     *         response="201",
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/AuthUserRequest")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad request",
     *     ),
     *      @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(ref="#/components/schemas/AuthUserRequest")
     *     )
     * )
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

            DB::table('users')
                ->where('id', $user['id'])
                ->update([
                    'remember_token' => $token,
                ]);

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
     *  * @OA\Post(
     *     path="/logout",
     *     operationId="logout",
     *     tags={"Registration and authtarization"},
     *     summary="Разлогинивание пользователя",
     *     security={
     *       {"userToken": {}},
     *     },
     *    @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/LogoutRequest")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad request",
     *     ),
     *      @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(ref="#/components/schemas/LogoutRequest")
     *     )
     * )
     * Разлогинивание пользователя
     * @param Request $request
     * @return object
     */
    public function logout(Request $request): object
    {
        $user = User::all()->where('email', $request['email'])->first();
        $token = $this->request->server->all();
        $userAttributes = $user->getAttributes();

        if (!array_key_exists('HTTP_USERTOKEN', $token) || $token['HTTP_USERTOKEN'] != $userAttributes['remember_token']) {

            return response('Вы не авторизованы', 401);
        }

        $user->tokens()->delete();

        return response('Вы были успешно разлогинены', 200);
    }
}
