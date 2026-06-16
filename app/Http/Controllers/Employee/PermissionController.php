<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\PermissionRequest;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = PermissionRequest::where('employee_id', session('employee_id'))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('employee.permission.index', compact('permissions'));
    }

    public function create()
    {
        return view('employee.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:terlambat,pulang_cepat',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_rencana' => 'required|date_format:H:i',
            'alasan' => 'required|string|min:10',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $jamNormal = $request->tipe === 'terlambat'
            ? Setting::get('jam_masuk', '08:00')
            : Setting::get('jam_keluar', '17:00');

        $durasi = abs(Carbon::parse($jamNormal)->diffInMinutes(Carbon::parse($request->jam_rencana)));

        $data = [
            'employee_id' => session('employee_id'),
            'tipe' => $request->tipe,
            'tanggal' => $request->tanggal,
            'jam_rencana' => $request->jam_rencana,
            'jam_normal' => $jamNormal,
            'durasi_menit' => $durasi,
            'alasan' => $request->alasan,
            'status' => 'pending',
        ];

        if ($request->hasFile('lampiran')) {
            $data['lampiran'] = $request->file('lampiran')->store('lampiran-izin', 'public');
        }

        PermissionRequest::create($data);

        return redirect()->route('employee.permission.index')->with('success', 'Permohonan izin berhasil diajukan.');
    }
}
