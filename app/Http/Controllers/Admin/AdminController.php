<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'role' => ['required', Rule::unique('users')->where(function ($query) {
                return $query->where('role', 2);
            })],
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ],[
            'role.unique' => 'You can make manager only one person!',
        ]);

        $admin = new User();
        $admin->name = $request->name;
        $admin->username = $request->username;
        $admin->role = $request->role;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->address = $request->address;
        $admin->save();

        return $admin;

    }

    public function changeStatus(Request $request)
    {
        if (isset($request->id) && isset($request->status)){
            $admin = User::find($request->id);
            $admin->status = $request->status == 1 ? 0 : 1;
            $admin->save();
            return $admin;
        }
    }

    public function edit($id)
    {
        $admin = User::find($id);
        return $admin;
    }

    public function update(Request $request, User $admin)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$admin->id,
            'role' => ['required', Rule::unique('users')->where(function ($query) {
                return $query->where('role', 2);
            })],
            'email' => 'required|email|unique:users,email,'.$admin->id,
        ],[
            'role.unique' => 'You can make manager only one person!',
        ]);

        $admin->name = $request->name;
        $admin->username = $request->username;
        $admin->role = $request->role;
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
