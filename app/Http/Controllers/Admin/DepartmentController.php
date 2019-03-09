<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('admin.department-list', compact('departments'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'departmentName' => 'required|unique:departments,dept_name'
        ]);

        $dept = new Department();
        $dept->dept_name = $request->departmentName;
        $dept->dept_details = $request->departmentDetails;
        $dept->save();

        return $dept;

    }


    public function edit($id)
    {
        $department = Department::find($id);
        return $department;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'departmentName' => 'required|unique:departments,dept_name'
        ]);

        $department = Department::find($id);
        $department->dept_name = $request->departmentName;
        $department->dept_details = $request->departmentDetails;
        $department->save();

        return $department;
    }

    public function destroy(Department $department)
    {
        $status = $department->delete();

        if ($status) return 'ok';

    }
}
