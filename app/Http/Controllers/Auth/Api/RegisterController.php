<?php

namespace App\Http\Controllers\Auth\Api;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data): \App\User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'api_token' => User::generateToken(),
        ]);

    }

    protected function regist(Request $request): \Illuminate\Http\JsonResponse
    {
        [$result, $code] = $this->register($request);
        return response()->json($result, $code);
    }


    public function register(Request $request): array
    {
        $validator = $this->validator($request->post());
        if ($validator->fails()) {
            return [$validator->errors(), 400];
        }
        event(new \Illuminate\Auth\Events\Registered($user = $this->create($request->all())));
        return $this->registered($request, $user);
    }

    protected function registered(Request $request, $user): array
    {
        return [['user' => $user->name, 'email' => $user->email, 'api_token' => $user->api_token], 201];
    }

}
