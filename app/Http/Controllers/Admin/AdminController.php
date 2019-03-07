<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::all();
        return view('admin.admin-list', compact('admins'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $admin = new User();
        $admin->name = $request->name;
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->address = $request->address;
        $admin->save();

        return $admin;

    }

    public function edit(User $admin)
    {
        return $admin;
    }

    public function update(Request $request, User $admin)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$admin->id,
            'email' => 'required|email|unique:users,email,'.$admin->id,
        ]);

        $admin->name = $request->name;
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->address = $request->address;
        $admin->save();

        return $admin;
    }

    public function destroy(User $admin)
    {
        $status = $admin->delete();

        if ($status) return 'ok';

    }
}
