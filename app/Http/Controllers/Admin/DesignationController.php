<?php

namespace App\Http\Controllers\Admin;

use App\Designation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DesignationController extends Controller
{

    public function index()
    {
        $designations = Designation::all();
        return view('admin.designation-list', compact('designations'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'designationName' => 'required|unique:designations,desg_name'
        ]);

        $desg = new Designation();
        $desg->desg_name = $request->designationName;
        $desg->desg_details = $request->designationDetails;
        $desg->save();

        return $desg;

    }

    public function edit($id)
    {
        $designation = Designation::find($id);
        return $designation;
    }

    public function update(Request $request, Designation $designation)
    {
        $designation->desg_name = $request->designationName;
        $designation->desg_details = $request->designationDetails;
        $designation->save();

        return $designation;
    }

    public function destroy(Designation $designation)
    {
        $status = $designation->delete();

        if ($status) return 'ok';

    }
}
