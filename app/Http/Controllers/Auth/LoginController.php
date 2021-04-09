<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
//    protected $redirectTo = RouteServiceProvider::HOME;
    public function redirectTo(){
        $depart= Auth::user()->department_id;
        switch ($depart){
            case 1:
                return "/joyCenter/home";
                break;
            case 2:
                return "/graceCenter";
                break;
            case 3:
                return "/generalist";
                break;
            case 4:
                return "/dentist";
                break;
            case 5:
                return"/pink";
                break;
            case 6:
                return "/cash/home";
                break;

        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function username()
    {
        return "employee_id";
    }
}
