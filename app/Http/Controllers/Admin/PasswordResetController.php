<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use App\Password;
use App\User;
use DB;

class PasswordResetController extends Controller
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function resetForm()
    {
        return view('admin.sendLink');
    }
    public function sendEmailLink(Request $request)
    {
        $this->validate($request, ['email' => 'required']);
        $details = $this->user->where('email', $request->email)->first();
        if ($details) {
            $randomNumber = str_random(10);

            $token_withSlash = bcrypt($randomNumber);

            $token = str_replace('/', '', $token_withSlash);
            // saving token and user name
            $savedata = ['email' => $request->email, 'token' => $token, 'created_at' => \Carbon\Carbon::now()->toDateTimeString()];
            Password::insert($savedata);
            //sending email link
            $data = ['email' => $request->email, 'token' => $token];
            Mail::send('email.emailLinkTemplate', $data, function ($message) use ($data) {
                $message->to($data['email'])->from('info@test.com');
                $message->subject('email link');
            });
            return redirect()->back()->with('message', 'Email has been sent to your email');
        } else {
            return redirect()->back()->with('message', 'Email does not exist');
        }
    }
    public function passwordResetForm(Request $request, $token)
    {
        if (isset($token) && $token != "") {
            $data = DB::table('password_resets')->where('token', $token)->first();

            if ($data) {
                return view('admin.passwordReset', compact('data'));
            } else {
                echo "token is wrong";
            }
        } else {
            echo "token not found";
        }
    }
    public function updatePassword(Request $request)
    {
        $detail = $this->user->where('email', $request->email)->first();
        $formData = $request->all();
        if ($request->password) {
            $formData['password'] = bcrypt($request->password);
        }
        $detail->update($formData);
        return redirect()->route('login')->with('message', "Password has been changed");
    }
}
