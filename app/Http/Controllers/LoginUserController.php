<?php

namespace App\Http\Controllers;
use App\Models\Dtruser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginUserController extends Controller
{
    //
    public function index(Request $req){

        $req->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = Dtruser::where('username', $req->username)->first();

        if(!$user){
            return back()->withErrors(['username' => 'User not found'])->withInput();
        }

        if(!Hash::check($req->password, $user->password)){
            return back()->withErrors(['password' => 'Incorrect password'])->withInput();
        }

            $req->session()->put('user_id', $user->id);
            $req->session()->put('usertype', $user->usertype);
            $req->session()->put('user', $user);
            switch ($user->usertype) {
                case 0:
                    // redirect to requestor
                    return redirect()->route('requestForm');
                case 1:
                    // Redirect to the admin dashboard
                    return redirect()->route('dashboard');
                case 2:
                    // Redirect to the technician page
                    return redirect()->route('technician.request');
                default:
                // For any other user type, you can define a default behavior
                return redirect()->route('dashboard');
            }
    }

    public function logout(Request $req){

        $req->session()->forget(['user_id', 'usertype']);

         // Invalidate the session
        $req->session()->invalidate();

        // Regenerate the CSRF token
        $req->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been successfully logged out.');
    }
}
