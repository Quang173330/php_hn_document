<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\Category;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $categories = Category::with('categories')
            ->where('parent_id', '=', config('uploads.category_root'))
            ->get();

        return view('login', compact('categories'));
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->guard()->validate($this->credentials($request))) {
            if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
                'status' => config('user.confirm')
            ])) {
                $admin_role = Role::where('name', config('user.role_admin'))->first();
                if (Auth::attempt([
                    'email' => $request->email,
                    'password' => $request->password,
                    'role_id' => $admin_role->id,
                ])) {
                    return $this->sendLoginAdminResponse($request);
                }
                return $this->sendLoginResponse($request);
            } else {
                $this->incrementLoginAttempts($request);

                return $this->sendFailedLoginResponseUnconfirmed($request);
            }
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendFailedLoginResponseUnconfirmed(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.unconfirmed')],
        ]);
    }

    protected function sendLoginAdminResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->route('admin.home');
    }
}
