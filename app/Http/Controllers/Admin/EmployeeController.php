<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Designation;
use App\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $designations = Designation::select('id', 'desg_name')->get();
        $departments = Department::select('id', 'dept_name')->get();

        $employees = Employee::all();

//        dd($departments. $designations);

        return view('admin.employee-list', compact('designations', 'departments', 'employees'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'                  => 'required',
            'designation'           => 'required',
            'department'            => 'required',
            'username'              => 'required|unique:employees',
            'contactNumber'         => 'required|digits:13',
            'email'                 => 'required|email|unique:employees',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ],[
            'contactNumber.digits' => 'The contact number must be 13 digits starting with 88.'
        ]);

        $employee = new Employee();
        $employee->name = $request->name;
        $employee->desg_id = $request->designation;
        $employee->dept_id = $request->department;
        $employee->username = $request->username;
        $employee->phone = $request->contactNumber;
        $employee->email = $request->email;
        $employee->password = bcrypt($request->password);
        $employee->address = $request->address;
        $employee->save();

        return $employee;
    }

    public function changeStatus(Request $request)
    {
        if (isset($request->id) && isset($request->status)){
            $employee = Employee::find($request->id);
            $employee->status = $request->status == 1 ? 0 : 1;
            $employee->save();
            return $employee;
        }
    }

    public function edit(Employee $employee)
    {
        return $employee;
    }

    public function update(Request $request, Employee $employee)
    {
        $this->validate($request, [
            'name'                  => 'required',
            'designation'           => 'required',
            'department'            => 'required',
            'username'              => 'required|unique:employees,username,'.$employee->id,
            'contactNumber'         => 'required|digits:13',
            'email'                 => 'required|email|unique:employees,email,'.$employee->id,
        ],[
            'contactNumber.digits' => 'The contact number must be 13 digits starting with 88.'
        ]);

        $employee->name = $request->name;
        $employee->desg_id = $request->designation;
        $employee->dept_id = $request->department;
        $employee->username = $request->username;
        $employee->phone = $request->contactNumber;
        $employee->email = $request->email;
        $employee->address = $request->address;
        $employee->save();

        return $employee;
    }

    public function destroy(Employee $employee)
    {
        $status = $employee->delete();

        if ($status) return 'ok';
    }

    public function changePassword(Request $request){
        $this->validate($request, [
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|same:newPassword',
        ]);

        Employee::where('id', $request->id)->update(['password' => bcrypt($request->newPassword)]);

        return 'success';
    }
}
