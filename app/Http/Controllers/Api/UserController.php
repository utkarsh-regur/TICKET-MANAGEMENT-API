<?php

namespace App\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
 
class UserController extends Controller
{
    public $successStatus = 200;

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Login"},
     *     summary="Login an existing user",
     *     description="Login an existing user",
     *     operationId="login",
     *      @OA\RequestBody(
     *      required=true,   
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
	 *						@OA\Property(
     *                          property="password",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "email":"example@email.com",
	 *                     "password":"abc123"
     *                }
     *             )
     *         )
     *      ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *      
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error in loggin in"
     *     )
     * )
     */
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('TicketsApp')-> accessToken; 
            $success['userId'] = $user->id;

            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
 
 /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Register"},
     *     summary="Register a new user",
     *     description="Register a new user with email and password",
     *     operationId="register",
     *      @OA\RequestBody(
     *      required=true,   
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
	 *						@OA\Property(
     *                          property="password",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "name":"username",
     *                     "email":"example@email.com",
	 *                     "password":"abc123"
     *                }
     *             )
     *         )
     *      ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="User registered successfully",
     *      
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error in registering user"
     *     )
     * )
     */
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            
        ]);

        if ($validator->fails()) { 
             return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all();

        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('TicketsApp')-> accessToken; 
        $success['name'] =  $user->name;
        
        return response()->json(['success'=>$success], $this-> successStatus); 
    }
 
/**
     * @OA\Get(
     *     path="/api/profile",
     *     tags={"Profile"},
     *     summary="Get user details",
     *     description="Get user details",
     *     operationId="userDetails",
     *     security={{"passport": {}},},
     *     @OA\Response(
     *         response=200,
     *         description="User details fetched successfully",
     *         @OA\MediaType(
     *           mediaType="application/json",
     *          )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error in fetching user details"
     *     )
     * )
     */
    public function userDetails() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    }
}
