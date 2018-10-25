<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        return Validator::make($request->post(), [
            $this->username() => ['required','string','exists:users,'.$this->username(),],
            'password' => ['required', 'string'],
        ]);
    }

    public function login(Request $request)
    {
        $validator = $this->validateLogin($request);

        if ($validator->fails()) {
            return $this->jsonResponse($validator->errors(), 400);
        }

        if (!$this->attemptLogin($request)) {
            return $this->sendFailedLoginResponse($request);

        }
        $user = $this->guard()->user();
        $user->update(['api_token' => User::generateToken()]);

        return $this->jsonResponse(['data' => $user->toArray(),], 200);
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {

        $user = \Auth::guard('api')->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
            $message = 'User logged out.';
            $code = 200;
        } else {
            $message = 'Invalid data';
            $code = 400;
        }

        return $this->jsonResponse(['data' => $message], $code);
    }


}
