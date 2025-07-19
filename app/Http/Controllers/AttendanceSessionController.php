<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSession;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('pages.attendance_session.index', [
            'type_menu' => 'attendance_sessions',
            'attendance_sessions' => AttendanceSession::with(['class', 'dosen'])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dosens = User::where('role', 'dosen')->get();
        if (Auth::user()->role == 'dosen') {
            $dosens = $dosens->where('id', Auth::user()->id);
        }
        return view('pages.attendance_session.create', [
            'type_menu' => 'attendance_sessions',
            'classes' => Company::all(),
            'dosens' => $dosens,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'dosen_id' => 'required|exists:users,id',
            'session_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|in:on,off',
        ]);

        AttendanceSession::create($request->all());

        if ($request->status == 'on') {
            $attendanceSession = Company::find($request->class_id);
            $attendanceSession->update(['attendance_type' => 'Face']);
        } else {
            $attendanceSession = Company::find($request->class_id);
            $attendanceSession->update(['attendance_type' => 'None']);
        }

        return redirect()->route('session.index')->with('success', 'Attendance session created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AttendanceSession $attendanceSession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $attendanceSession = AttendanceSession::findOrFail($id);
        $dosens = User::where('role', 'dosen');

        if (Auth::user()->role == 'dosen') {
            $dosens = $dosens->where('id', Auth::user()->id);
        }

        $dosens = $dosens->get(); // Execute the query here

        return view('pages.attendance_session.edit', [
            'type_menu' => 'attendance_sessions',
            'attendanceSession' => $attendanceSession,
            'classes' => Company::all(),
            'dosens' => $dosens,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        // Ambil hanya kolom yang diizinkan untuk diupdate
        $data = $request->only([
            'class_id',
            'dosen_id',
            'session_date',
            'start_time',
            'end_time',
            'status',
        ]);

        $attendanceSession = AttendanceSession::findOrFail($id);
        $attendanceSession->update($data);

        // Update attendance_type pada Company sesuai status
        $company = Company::find($request->class_id);
        if ($company) {
            $company->update([
                'attendance_type' => $request->status == 'on' ? 'Face' : 'None'
            ]);
        }

        return redirect()->route('session.index')->with('success', 'Attendance session updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $attendanceSession = AttendanceSession::findOrFail($id);
        $attendanceSession->delete();

        return redirect()->route('session.index')->with('success', 'Attendance session deleted successfully.');
    }
}
