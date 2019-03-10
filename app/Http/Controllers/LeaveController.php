<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Leave;
use App\LeaveType;
use App\Mail\AcceptOrRejectMail;
use App\Mail\LeaveRequestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LeaveController extends Controller
{
    public function index()
    {
        $leaveTypes = LeaveType::all();
        $leaves = Leave::with('type');

        if (auth('employee')->check()) $leaves = $leaves->where('emp_id', auth('employee')->id());

        $leaves = $leaves->orderBy('id', 'desc')->get();

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

        $totalDays = date_diff(date_create($request->dateFrom),date_create($request->dateTo))->format("%a")+1;

        if ($request->leaveType){
            $typeWiseLeave = LeaveType::select('id', 'type_name', 'total_days')->where('id', $request->leaveType)->first();
            $totalLeave = Leave::where('emp_id', auth('employee')->id())->where('type_id', $request->leaveType)->where('status', 1)->whereYear('date_from', date('Y'))->sum('total_days');

            if (($totalLeave+$totalDays) > $typeWiseLeave->total_days){
                return response()->json(['errors' => ['dateFrom' => ["You have only ". ($typeWiseLeave->total_days - $totalLeave) . " days of ".$typeWiseLeave->type_name." in this year!"]]], 422);
            }
        }

        $leave = new Leave();
        $leave->emp_id = auth('employee')->id();
        $leave->type_id = $request->leaveType;
        $leave->date_from = $request->dateFrom;
        $leave->date_to = $request->dateTo;
        $leave->total_days = $totalDays;
        $leave->details = $request->details;
        $leave->save();

        $leave = Leave::with('type')->find($leave->id);

        Mail::to(auth('employee')->user()->email)->send(new LeaveRequestMail($leave, $totalDays));

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

        $totalDays = date_diff(date_create($request->dateFrom),date_create($request->dateTo))->format("%a")+1;

        if ($request->leaveType){
            $typeWiseLeave = LeaveType::select('id', 'type_name', 'total_days')->where('id', $request->leaveType)->first();
            $totalLeave = Leave::where('emp_id', auth('employee')->id())->where('type_id', $request->leaveType)->where('status', 1)->whereYear('date_from', date('Y'))->sum('total_days');

            if (($totalLeave+$totalDays) > $typeWiseLeave->total_days){
                return response()->json(['errors' => ['dateFrom' => ["The employee has only ". ($typeWiseLeave->total_days - $totalLeave) . " days of ".$typeWiseLeave->type_name." in this year!"]]], 422);
            }
        }

        $leave = Leave::with('type')->find($id);
        $leave->emp_id = $request->empId;
        $leave->type_id = $request->leaveType;
        $leave->date_from = $request->dateFrom;
        $leave->date_to = $request->dateTo;
        $leave->total_days = $totalDays;
        $leave->details = $request->details;
        $leave->save();

        return $leave;
    }

    public function changeStatus(Request $request)
    {

        if (isset($request->id) && isset($request->status)){
            $leave = Leave::with('type')->find($request->id);
            $leave->status = $request->status;
            $leave->save();

            $status = $request->status == 1 ? 'Approved' : 'Rejected';
            $employee = Employee::where('id', $leave->emp_id)->first();
            Mail::to($employee->email)->send(new AcceptOrRejectMail($status, $leave));

            return $leave;
        }
    }


}
