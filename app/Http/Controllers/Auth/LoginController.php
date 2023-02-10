<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller {
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
	public function __construct() {
		$this->middleware('guest')->except('logout');
	}

	/**
	 * Get the failed login response instance.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function sendFailedLoginResponse(Request $request) {
		$errors  = [$this->username() => array(trans('auth.failed'))];
		$message = 'These credentials do not match our records.';

		// Load user from database
		$user = User::where($this->username(), $request->{$this->username()})->first();

		if ($user && !Hash::check($request->password, $user->password)) {
			$errors  = ['password' => array('Wrong password.')];
			$message = 'Wrong password.';
		}

		if ($request->expectsJson()) {
			return response()->json(array('message' => $message, 'errors' => $errors), 422);
		}

		return redirect()->back()
			->withInput($request->only($this->username(), 'remember'))
			->withErrors($errors);
	}

	/**
	 * The user has been authenticated.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  mixed  $user
	 * @return mixed
	 */
	protected function authenticated(Request $request, $user) {
		return response()->json($user, 200);
	}

	public function loggedOut(Request $request) {
		return response()->json(null);
	}
}
