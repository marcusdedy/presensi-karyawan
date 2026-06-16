<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\OvertimeRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    public function index()
    {
        $overtimes = OvertimeRequest::where('employee_id', session('employee_id'))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('employee.overtime.index', compact('overtimes'));
    }

    public function create()
    {
        return view('employee.overtime.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'alasan' => 'required|string|min:10',
            'tipe_hari' => 'required|in:kerja,libur,weekend',
        ]);

        $durasi = Carbon::parse($request->jam_mulai)->diffInMinutes(Carbon::parse($request->jam_selesai));

        OvertimeRequest::create([
            'employee_id' => session('employee_id'),
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'durasi_menit' => $durasi,
            'alasan' => $request->alasan,
            'tipe_hari' => $request->tipe_hari,
            'status' => 'pending',
        ]);

        return redirect()->route('employee.overtime.index')->with('success', 'Pengajuan lembur berhasil diajukan.');
    }
}
