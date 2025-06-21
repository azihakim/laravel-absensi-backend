<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceRecapExport;
use App\Models\Attendance;
use App\Models\Permission;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //index
    public function index(Request $request)
    {
        $attendances = Attendance::with('user')
            ->when($request->input('name'), function ($query, $name) {
                $query->whereHas('user', function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                });
            })->orderBy('id', 'desc')->paginate(10);
        return view('pages.absensi.index', compact('attendances'));
    }

    public function recapForm()
    {
        return view('pages.absensi.recap_form');
    }

    public function recap(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Ambil data absensi dalam rentang tanggal
        $attendances = Attendance::whereBetween('date', [$startDate, $endDate])
            ->get();

        // Ambil data izin yang disetujui dalam rentang tanggal
        $permissions = Permission::whereBetween('date_permission', [$startDate, $endDate])
            ->where('is_approved', true)
            ->get();

        // Gabungkan data absensi dan izin (ini perlu disesuaikan sesuai kebutuhan tampilan)
        $recapData = $this->prepareRecapData($attendances, $permissions, $startDate, $endDate);

        // Generate nama file
        $fileName = 'Rekap Absensi ' . $startDate . ' - ' . $endDate . '.xlsx';
        // Download Excel
        return \Maatwebsite\Excel\Facades\Excel::download(new AttendanceRecapExport($startDate, $endDate, $recapData), $fileName);
    }

    private function prepareRecapData($attendances, $permissions, $startDate, $endDate)
    {
        $recapData = [];

        // Buat array tanggal untuk rentang yang dipilih
        $dates = [];
        $currentDate = strtotime($startDate);
        $endDateTimestamp = strtotime($endDate);

        while ($currentDate <= $endDateTimestamp) {
            $dates[] = date('Y-m-d', $currentDate);
            $currentDate = strtotime('+1 day', $currentDate);
        }

        // Ambil semua user
        $users = \App\Models\User::all();

        foreach ($users as $user) {
            $userData = [
                'user' => $user,
                'data' => [], // Menggunakan array 'data' untuk menyimpan informasi (absensi atau izin)
            ];

            foreach ($dates as $date) {
                // Cek apakah ada izin yang disetujui
                $permission = $permissions->where('user_id', $user->id)->where('date_permission', $date)->first();

                if ($permission) {
                    // Jika ada izin, gunakan data izin
                    $userData['data'][$date] = [
                        'type' => 'permission',
                        'data' => $permission,
                    ];
                } else {
                    // Jika tidak ada izin, cek apakah ada absensi
                    $attendance = $attendances->where('user_id', $user->id)->where('date', $date)->first();

                    if ($attendance) {
                        // Jika ada absensi, gunakan data absensi
                        $userData['data'][$date] = [
                            'type' => 'attendance',
                            'data' => $attendance,
                        ];
                    }
                    // Jika tidak ada izin dan tidak ada absensi, maka tidak ada data untuk tanggal ini
                    // (tidak perlu membuat entri null)
                }
            }
            $recapData[] = $userData;
        }
        return $recapData;
    }
}
