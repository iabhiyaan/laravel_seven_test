<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Session;

class LoginController extends Controller
{
   public function login()
   {
      return view('auth.login');
   }
   public function postLogin(Request $request)
   {

      $this->validate($request, [
         'email'    => 'required',
         'password' => 'required',
      ]);
      $user = User::where('email', $request->email)->first();

      if (!$user) {
         return back()->with('message', 'User not found');
      }

      if (!\Hash::check($request->password, $user->password)) {
         return back()->with('message', 'Invalid Username\Password');
      }

      if ($user->role == 'admin' && $user->publish == 0) {
         return back()->with('message', "Your account is inactive!<br> Please contact Team.");
      }

      if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
         return redirect()->route('dashboard');
      } else {
         return back()->withInput()->withErrors(['email' => 'something is wrong!']);
      }
   }
   public function admin__logout()
   {
      Auth::logout();
      Session::flush();
      return redirect()->route('login');
   }
}
