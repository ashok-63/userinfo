<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Carbon;

class BackendController extends Controller
{
    public function login()
    {
        return view('login.login');
    }
    public function handleLogin(Request $req)
    {
        $req->validate([
            'userName' => 'required',
            'passWord' => 'required',
        ]);
        //dd($req->all());
        $user_check = User::where('userName', '=', $req->userName)->where('passWord', '=', $req->passWord)->first();
        //dd($user_check);
        if ($user_check) {
            if (Auth::guard('web')->attempt($req->only(['userName', 'passWord']))) {
                $Loginhistory = new Loginhistory();
                $Loginhistory->login_id = auth()->user()->userid;
                $Loginhistory->username = auth()->user()->userName;
                $Loginhistory->indate = Carbon::now();
                $Loginhistory->operation = "Login";
                $Loginhistory->save();
                return redirect()->route('dashboard');
            }
        }
        //return redirect()->back()->with('error', 'Invalid Credentials');
        return redirect()->back()->withInput($req->all())->with('error', 'Invalid Credentials');
    }
    public function logout()
    {
        if (isset(auth()->user()->userid)) {
            $Loginhistory = new Loginhistory();
            $Loginhistory->login_id = auth()->user()->userid;
            $Loginhistory->username = auth()->user()->userName;
            $Loginhistory->indate = Carbon::now();
            $Loginhistory->operation = "Logout";
            $Loginhistory->save();
        }
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }
}
