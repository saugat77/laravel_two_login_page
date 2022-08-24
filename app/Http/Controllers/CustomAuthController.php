<?php

namespace App\Http\Controllers;
use App\Models\customer;
use Hash;
use Session;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.customer-login');
    }


    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return view('auth.customer-dasboard')->intended('dashboard')
                        ->withSuccess('Signed in');
        }

        return view("auth.customer-dasboard")->withSuccess('Login details are not valid');
    }



    public function registration()
    {
        return view('auth.customer-registration');
    }


    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return view("auth.customer-dasboard")->withSuccess('You have signed-in');
    }


    public function create(array $data)
    {
      return Customer::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }


    public function dashboard()
    {
        if(Auth::check()){
            return view('auth.customer-dashboard');
        }

        return redirect("customer.login")->withSuccess('You are not allowed to access');
    }


    public function signOut() {
        Session::flush();
        Auth::logout();

        return Redirect('customer.login');
    }
}
