<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\User;
use JWTAuth;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     tags={"Auth"},
     *     summary="Log in",
     *	   @OA\RequestBody(
     *          description= "Provide auth credentials",
     *          required=true,
     *          @OA\JsonContent(
     *     			required={"email", "password"},
     *              type="object",
     *              @OA\Property(property="email", type="string", format="email", example="user.test@gmail.com"),
     *              @OA\Property(property="password", type="string", format="password", example="password")
     *          )
     *     ),
     *     @OA\Response(
     *			response=200,
     *         	description="Success : Get JWT token",
     *      	@OA\JsonContent(
     *				@OA\Property(property="token", type="string", example="BearerToken"),
     * 			)
     * 		),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error",
     *      )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws
     */
    public function login()
    {
        $this->validate(request(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string']
        ]);

        if (! auth()->attempt(request()->only(['email', 'password']))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = JWTAuth::fromUser(auth()->user());

        return response()->json(['token' => $token, 'user' => new UserCollection(auth()->user())]);
    }

    /**
     * Add a new user
     *
     * @OA\Post(
     *     path="/auth/register",
     *     tags={"Auth"},
     *     summary="Add a new user",
     *     @OA\RequestBody(
     *          description= "Provide user informations",
     *          required=true,
     *          @OA\JsonContent(
     *     			required={"name", "email", "password"},
     *              type="object",
     *     			@OA\Property(property="name", type="string", example="nom"),
     *              @OA\Property(property="email", type="string", format="email", example="mail@mail.com"),
     *              @OA\Property(property="password", type="string", format="password", example="password"),
     *          )
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="user created",
     *         @OA\JsonContent(
     *     			@OA\Property(property="token", type="string", example="bearerToken"),
     * 			)
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error",
     *      )
     *    )
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws
     */
    public function register()
    {
        $this->validate(request(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string'],
        ]);

        $user = new User();
        $user->email = request('email');
        $user->name = request('name');
        $user->password = Hash::make(request('password'));
        $user->save();

        //TODO Code de parainnage

        $credentials = request()->only('email', 'password');
        $token = JWTAuth::attempt($credentials);

        return response()->json(['token' => $token, 'user' => new UserCollection(auth()->user())]);
    }


    /**
     * Logout
     *
     * @OA\Post(
     *     path="/auth/logout",
     *     tags={"Auth"},
     *     summary="Logout",
     *     security={{"jwt":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="success message",
     *     	   @OA\JsonContent(
     *     			@OA\Property(property="message", type="string", example="Successfully logged out"),
     * 			)
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *      ),
     *    )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get a JWT via given credentials.
     *
     * @OA\Get(
     *     path="/auth/user-profile",
     *     tags={"Auth"},
     *     summary="Get loggued user informations",
     *     security={{"jwt":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success : Get user informations",
     *     	   @OA\JsonContent( @OA\Property(ref="#/components/schemas/User") )
     * 		),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *      ),
     *    )
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

}