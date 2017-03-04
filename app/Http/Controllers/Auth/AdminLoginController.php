<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AdminLoginController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest:admin');
	}

	public function showLoginForm()
	{
		return view('auth.admin-login');
	}

	public function login(Request $request)
	{
		$credentials = [
			'email' 	=> request('email'),
			'password' 	=> request('password')
		];

		// Validate the form data
		$this->validate($request, [
			'email' 	=> 'required|email',
			'password' 	=> 'required|min:6'
		]);

		// Attempt to log user in
		if (auth()->guard('admin')->attempt($credentials, $request->remember)) {
			// If successful, then redirect to their intended location
			return redirect()->intended(route('admin.dashboard'));
		}

		// If unsuccessful, then redirect back to the login with the form data
		return redirect()->back()->withInput(request()->only('email', 'remember'));

	}
}
