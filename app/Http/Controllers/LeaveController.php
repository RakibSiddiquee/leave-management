<?php

namespace App\Http\Controllers;

use App\Leave;
use App\LeaveType;
use App\Mail\LeaveRequestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        $leave = Leave::with('type')->find($leave->id);

        Mail::to(auth('employee')->user()->email)->send(new LeaveRequestMail($leave));

        return $leave;

    }

    public function show($id)
    {
        $leave = Leave::with('type')->find($id);
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

        $leave = Leave::with('type')->find($id);
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
