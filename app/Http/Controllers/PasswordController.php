<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class PasswordController extends Controller
{

    /**
     * PasswordController constructor.
     */
    public function __construct()
    {
        $this->middleware('users');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function change()
    {
        return view('users.passwords.change');
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changePass(Request $request)
    {
        $old_pass = $request->get('old_password');
        $pass = \Auth::user()->password;
        $validator = \Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ], [
            'required' => '密码不能为空!',
            'min'=> '密码不能小于6位!',
            'confirmed'=> '两次输入的密码不相同!'
        ]);
        if ($validator->fails()) {
            return redirect('/password/change')
                ->withErrors($validator)
                ->withInput();
        }
        if (\Hash::check($old_pass, $pass)) {
            $user = User::find(\Auth::user()->id);
            $user->password = $request->get('password');
            $user->save();
            \Session::flash('success_change','密码更改成功!请重新登录!');
            \Auth::logout();
            return redirect('/');
        } else {
            session()->flash('old_pass_error','原密码不正确!');
            return redirect()->back();
        }
    }
}
