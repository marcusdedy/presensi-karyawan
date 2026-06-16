<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('employee.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nik' => 'required|string',
            'pin' => 'required|string|min:4|max:8',
        ]);

        $employee = Employee::where('nik', $request->nik)->where('status', 'aktif')->first();

        if (!$employee || !Hash::check($request->pin, $employee->pin)) {
            return back()->with('error', 'NIK atau PIN salah.')->withInput(['nik' => $request->nik]);
        }

        session([
            'employee_id' => $employee->id,
            'employee_nama' => $employee->nama_lengkap,
            'employee_nik' => $employee->nik,
        ]);

        return redirect()->route('employee.dashboard');
    }

    public function logout()
    {
        session()->forget(['employee_id', 'employee_nama', 'employee_nik']);
        return redirect()->route('employee.login')->with('success', 'Berhasil logout.');
    }
}
