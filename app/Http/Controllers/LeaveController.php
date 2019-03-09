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
        $leaves = Leave::with('type')->where('emp_id', auth('employee')->id())->orderBy('id', 'desc')->get();

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

        $leave = new Leave();
        $leave->emp_id = auth('employee')->id();
        $leave->type_id = $request->leaveType;
        $leave->date_from = $request->dateFrom;
        $leave->date_to = $request->dateTo;
        $leave->total_days = date_diff(date_create($request->dateFrom),date_create($request->dateTo))->format("%a")+1;
        $leave->details = $request->details;
        $leave->save();

        return $leave;

    }

    public function edit($id)
    {
        $leave = Leave::find($id);
        return $leave;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'leaveType' => 'required',
            'dateFrom' => 'required',
            'dateTo' => 'required',
            'details' => 'required',
        ]);

        $leave = Leave::find($id);
        $leave->emp_id = auth('employee')->id();
        $leave->type_id = $request->leaveType;
        $leave->date_from = $request->dateFrom;
        $leave->date_to = $request->dateTo;
        $leave->total_days = date_diff(date_create($request->dateFrom),date_create($request->dateTo))->format("%a")+1;
        $leave->details = $request->details;
        $leave->save();

        return $leave;
    }

    public function destroy($id)
    {
        $leave = Leave::find($id);
        $status = $leave->delete();

        if ($status) return 'ok';

    }
}
