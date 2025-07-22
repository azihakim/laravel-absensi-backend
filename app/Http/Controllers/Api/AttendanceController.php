<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Permission;

class AttendanceController extends Controller
{
    //checkin
    public function checkin(Request $request)
    {
        // Cek apakah user sudah mengajukan izin untuk hari ini
        $hasPermission = Permission::where('user_id', $request->user()->id)
            ->where('date', date('Y-m-d'))
            ->exists();

        if ($hasPermission) {
            return response([
                'message' => 'Tidak dapat absen, Anda sudah mengajukan izin untuk hari ini.'
            ], 400);
        }

        //validate lat and long
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        //save new attendance
        $attendance = new Attendance;
        $attendance->user_id = $request->user()->id;
        $attendance->date = date('Y-m-d');
        $attendance->time_in = date('H:i:s');
        $attendance->latlon_in = $request->latitude . ',' . $request->longitude;
        $attendance->save();

        return response([
            'message' => 'Checkin success',
            'attendance' => $attendance
        ], 200);
    }

    //checkout
    public function checkout(Request $request)
    {
        //validate lat and long
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        //get today attendance
        $attendance = Attendance::where('user_id', $request->user()->id)
            ->where('date', date('Y-m-d'))
            ->first();

        //check if attendance not found
        if (!$attendance) {
            return response(['message' => 'Checkin first'], 400);
        }

        //save checkout
        $attendance->time_out = date('H:i:s');
        $attendance->latlon_out = $request->latitude . ',' . $request->longitude;
        $attendance->save();

        return response([
            'message' => 'Checkout success',
            'attendance' => $attendance
        ], 200);
    }

    //check is checkedin
    public function isCheckedin(Request $request)
    {
        //get today attendance
        $attendance = Attendance::where('user_id', $request->user()->id)
            ->where('date', date('Y-m-d'))
            ->first();

        $isCheckout = $attendance ? $attendance->time_out : false;

        return response([
            'checkedin' => $attendance ? true : false,
            'checkedout' => $isCheckout ? true : false,
        ], 200);
    }

    //index
    public function index(Request $request)
    {
        $date = $request->input('date');

        $currentUser = $request->user();

        $query = Attendance::where('user_id', $currentUser->id);

        if ($date) {
            $query->where('date', $date);
        }

        $attendance = $query->get();

        return response([
            'message' => 'Success',
            'data' => $attendance
        ], 200);
    }

    public function history()
    {

        // Filter data absensi berdasarkan ID pengguna
        $attendances = Attendance::with('user')
            ->where('user_id', auth()->user()->id)
            ->get();

        $attendanceHistory = $attendances->map(function ($attendance) {
            return [
                'user_name' => $attendance->user->name,
                'date' => $attendance->date,
                'time_in' => $attendance->time_in,
                'time_out' => $attendance->time_out,
            ];
        });
        return response()->json(['data' => $attendanceHistory]);
    }
}
