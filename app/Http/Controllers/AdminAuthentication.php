<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use App\Models\Administrator;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class AdminAuthentication extends Controller
{
    public function login(Request $request)
    {
        $hashed = Hash::make('password', [
            'rounds' => 12,
        ]);

        // Administrator::create([
        //     'username' => 'user',
        //     'password' =>  'password'
        // ]);

        $administrator = Administrator::where('username', $request->username)->first();

        if (!$administrator) {
            return back()->with('error',  'Username not found');
        } else {
            
            if ($request->password == $administrator->password) {
                Session::put('username', $request->username);
                return redirect()->route('jca')->with('loggedIn', 'Hello ' . $request->username . '! You are signed in as admin.');

            }else{
                return back()->with('error',  'Incorrect password');
            }
        }
    }

    public function logout(){
        Session::flush();
        return redirect(route('admin.login'));
    }
}
