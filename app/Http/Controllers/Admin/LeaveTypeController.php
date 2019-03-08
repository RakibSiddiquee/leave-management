<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{

    public function index()
    {
        $leaveTypes = LeaveType::all();
        return view('admin.leave-type-list', compact('leaveTypes'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'typeName' => 'required|unique:leave_types,type_name',
            'totalDays' => 'required|digits_between:1,50'
        ]);

        $type = new LeaveType();
        $type->type_name = $request->typeName;
        $type->type_details = $request->typeDetails;
        $type->total_days = $request->totalDays;
        $type->save();

        return $type;

    }

    public function edit(LeaveType $leaveType)
    {
        return $leaveType;
    }

    public function update(Request $request, LeaveType $leaveType)
    {
        $this->validate($request, [
            'typeName' => 'required|unique:leave_types,type_name,'.$leaveType->id,
            'totalDays' => 'required|digits_between:1,50'
        ]);

        $leaveType->type_name = $request->typeName;
        $leaveType->type_details = $request->typeDetails;
        $leaveType->total_days = $request->totalDays;
        $leaveType->save();

        return $leaveType;
    }

    public function destroy(LeaveType $leaveType)
    {
        $status = $leaveType->delete();

        if ($status) return 'ok';

    }
}
