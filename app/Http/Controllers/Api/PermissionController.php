<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\Permission;
use Carbon\Carbon;

class PermissionController extends Controller
{
    //create
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'reason' => 'required',
        ]);
        $date = Carbon::parse($request->date)->format('Y-m-d');
        $attendanceExists = Attendance::where('user_id', $request->user()->id)
            ->where('date', $date)
            ->exists();

        if ($attendanceExists) {
            return response()->json(['message' => 'Sudah absen di hari tersebut'], 401);
        }

        $permission = new Permission();
        $permission->user_id = $request->user()->id;
        $permission->date_permission = $request->date;
        $permission->reason = $request->reason;
        $permission->is_approved = 0;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/permissions', $image->hashName());
            $permission->image = $image->hashName();
        }

        $permission->save();

        return response()->json(['message' => 'Permission created successfully'], 201);
    }
}
