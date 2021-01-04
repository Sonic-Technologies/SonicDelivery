<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class CustomAuthController extends Controller
{
    public function showAdminPage()
    {
        return view('admin');
    }

    public function showRegisterAdminPage()
    {
        return view('admin.register');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|max:15'
        ]);
        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('/dashboard');
        }
        
        return redirect()->back()->with('message', 'Invalid credentials!');
    }

    public function register(Request $request)
    {
        $this->validation($request);

        $request['password'] = bcrypt($request->password);

        User::create($request->all());

        return redirect('/sonicsalescms');
    }

    public function validation($request)
    {

        return $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|max:15',
        ]);

    }

    public function logout()
    {
        Auth::logout();
        return redirect('/sonicsalescms');
    }
}
