<?php

namespace App\Http\Controllers;

use App\Leave;
use App\LeaveType;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        $leaveTypes = LeaveType::all();
        $leaves = Leave::where('emp_id', auth('employee')->id())->orderBy('id', 'desc')->get();

        $view = auth('employee')->check() ? 'employee-leavelist' : 'admin.leave-list';

        return view($view, compact('leaveTypes', 'leaves'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'leaveType' => 'required',
            'dateFrom' => 'required',
            'dateTo' => 'required',
            'details' => 'required',
        ]);

        $type = new Leave();
        $type->emp_id = auth('employee')->id();
        $type->type_id = $request->leaveType;
        $type->date_from = $request->dateFrom;
        $type->date_to = $request->dateTo;
        $type->total_days = date_diff(date_create($request->dateFrom),date_create($request->dateTo))->format("%a");
        $type->details = $request->details;
        $type->save();

        return $type;

    }

    public function edit(Leave $leaveType)
    {
        return $leaveType;
    }

    public function update(Request $request, Leave $leaveType)
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

    public function destroy(Leave $leaveType)
    {
        $status = $leaveType->delete();

        if ($status) return 'ok';

    }
}
