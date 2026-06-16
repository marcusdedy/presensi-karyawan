<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerHistory;
use App\Models\Employee;
use Illuminate\Http\Request;

class CareerHistoryController extends Controller
{
    public function store(Request $request, Employee $employee)
    {
        $request->validate([
            'tipe' => 'required|in:promosi,demosi,mutasi,rotasi,perubahan_status',
            'tanggal_efektif' => 'required|date',
            'jabatan_baru' => 'nullable|string',
            'departemen_baru' => 'nullable|string',
            'status_baru' => 'nullable|string',
            'no_sk' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        CareerHistory::create([
            'employee_id' => $employee->id,
            'tipe' => $request->tipe,
            'tanggal_efektif' => $request->tanggal_efektif,
            'jabatan_lama' => $employee->position?->nama,
            'jabatan_baru' => $request->jabatan_baru,
            'departemen_lama' => $employee->department?->nama,
            'departemen_baru' => $request->departemen_baru,
            'status_lama' => $employee->status_karyawan,
            'status_baru' => $request->status_baru,
            'no_sk' => $request->no_sk,
            'catatan' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Riwayat karir berhasil ditambahkan.');
    }
}
