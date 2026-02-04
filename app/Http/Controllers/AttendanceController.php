<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendance;
use App\Employee;
use App\Payroll;
use App\PayrollDetail;
use App\PayrollComponent;
use App\Position;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Check if user is Karyawan
        if ($user && $user->role && strtolower($user->role->name) === 'karyawan') {
            $employee = Employee::where('user_id', $user->user_id)->first();

            if (!$employee) {
                return abort(403, 'Data karyawan tidak ditemukan untuk akun ini.');
            }

            // Stats for Dashboard - Counts for current month
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            $totalAttendance = Attendance::where('employee_nip', $employee->nip)
                ->whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->count();
            
            $totalLate = Attendance::where('employee_nip', $employee->nip)
                ->whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->where('status', 'Late')
                ->count();

            // Note: Permission and Alpha might need a separate table or status enum, assuming 'Permission' and 'Alpha' status exists or similar logic. 
            // For now, I'll assume status field handles this or it's 0 if not implemented yet.
            $totalPermission = Attendance::where('employee_nip', $employee->nip)
                ->whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->where('status', 'Permission')
                ->count();

            $totalAlpha = Attendance::where('employee_nip', $employee->nip)
                ->whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->where('status', 'Alpha')
                ->count();

            // Attendance History (Last 5 records)
            $attendanceHistory = Attendance::where('employee_nip', $employee->nip)
                ->orderBy('date', 'desc')
                ->limit(5)
                ->get();
            
            $today = Carbon::today()->toDateString();
            $todayAttendance = Attendance::where('employee_nip', $employee->nip)
                ->where('date', $today)
                ->first();

            return view('attendance.employee_dashboard', compact(
                'employee', 
                'totalAttendance', 
                'totalLate', 
                'totalPermission', 
                'totalAlpha', 
                'attendanceHistory', 
                'todayAttendance'
            ));
        }

        // Default Admin/HRD View
        $attendances = Attendance::with('employee')->orderBy('date', 'desc')->orderBy('time_in', 'desc')->get();
        return view('attendance.index', compact('attendances'));
    }

    public function scan()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $employee = Employee::where('user_id', $user->user_id)->first();
        $position = Position::where('position_id', $employee->position_id)->first();

        if (!$employee) {
            return redirect()->back()->with('error', 'Akun anda tidak terhubung dengan data karyawan.');
        }

        $today = Carbon::today()->toDateString();
        $attendance = Attendance::where('employee_nip', $employee->nip)
            ->where('date', $today)
            ->first();

        return view('attendance.scan', compact('employee', 'attendance', 'position'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required',
            'nip' => 'required|exists:employees,nip'
        ]);

        $img = $request->image;
        $folderPath = "public/attendance/";
        
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $request->nip . '_' . time() . '.png';
        
        $file = $folderPath . $fileName;
        Storage::put($file, $image_base64);

        $today = Carbon::today()->toDateString();
        $now = Carbon::now()->toTimeString();

        // Check if Late (Example: Late after 08:00 AM)
        // You can make this dynamic based on Employee Schedule if available
        $lateThreshold = '07:00:00';
        $status = ($now > $lateThreshold) ? 'Late' : 'Present';
        $latePenalty = 50000; // Deduct 50,000 if late

        $attendance = Attendance::where('employee_nip', $request->nip)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            // Check-in
            Attendance::create([
                'employee_nip' => $request->nip,
                'date' => $today,
                'time_in' => $now,
                'photo_in' => $fileName,
                'status' => $status
            ]);

            // Apply Deduction if Late
            if ($status === 'Late') {
                $this->applyDeduction($request->nip, 'Potongan Keterlambatan', $latePenalty);
                return response()->json(['success' => 'Berhasil Absen Masuk! (Terlambat)']);
            }

            return response()->json(['success' => 'Berhasil Absen Masuk!']);
        } else {
            // Check-out
            if ($attendance->time_out) {
                return response()->json(['error' => 'Anda sudah absen keluar hari ini.']);
            }

            $attendance->update([
                'time_out' => $now,
                'photo_out' => $fileName
            ]);
            return response()->json(['success' => 'Berhasil Absen Keluar!']);
        }
    }

    private function applyDeduction($nip, $name, $amount)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Find Payroll for current period, or Create it
        $payroll = Payroll::firstOrCreate(
            ['period_month' => $currentMonth, 'period_year' => $currentYear],
            ['status' => 'calculated']
        );
        
        // Find Payroll Detail for this employee, or Create it
        $detail = PayrollDetail::firstOrCreate(
            ['payroll_id' => $payroll->payroll_id, 'nip' => $nip],
            [
                'basic_salary' => 0,
                'total_allowance' => 0,
                'total_deduction' => 0,
                'total_salary' => 0
            ]
        );
        
        // Create Component
        PayrollComponent::create([
            'payroll_detail_id' => $detail->payroll_detail_id,
            'name' => $name,
            'type' => 'deduction',
            'amount' => $amount
        ]);

        // Update total_deduction and total_salary
        $detail->total_deduction += $amount;
        $detail->total_salary = $detail->basic_salary + $detail->total_allowance - $detail->total_deduction;
        $detail->save();
    }

    public function applyAlphaDeduction($nip)
    {
        // Example penalty for Alpha (Absent without notice)
        $alphaPenalty = 100000; 
        $this->applyDeduction($nip, 'Potongan Alpha', $alphaPenalty);
    }

    public function history()
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->user_id)->first();

        if (!$employee) {
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan.');
        }

        $attendances = Attendance::where('employee_nip', $employee->nip)
        ->orderBy('date', 'desc')
        ->get();

        return view('attendance.history', compact('attendances'));
    }
}
