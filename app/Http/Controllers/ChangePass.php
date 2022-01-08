<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePass extends Controller
{
    public function ChangePassword()
    {
        return view('admin.body.change_password');
    }

    public function UpdatePassword(Request $request)
    {
        $validateData = $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed',
        ]);

        $hashedPassword = auth()->user()->password;
        if (Hash::check($request->oldpassword, $hashedPassword)) {
            $user = User::find(auth()->id());
            $user->password = Hash::make($request->password);
            $user->save();
            auth()->logout();

            return redirect()->route('login')->with('success', 'Password is change successfully!');
        }

        return redirect()->back()->with('error', 'Current Password is invalid');
    }
}
