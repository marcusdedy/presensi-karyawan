<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\OvertimeRequest;
use App\Models\PermissionRequest;
use App\Services\LeaveService;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function __construct(private LeaveService $leaveService) {}

    // ===== CUTI =====
    public function leaveIndex(Request $request)
    {
        $query = LeaveRequest::with(['employee', 'leaveType']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'pending');
        }

        $leaveRequests = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.approval.leave', compact('leaveRequests'));
    }

    public function leaveApprove(LeaveRequest $leaveRequest, Request $request)
    {
        $this->leaveService->approveCuti($leaveRequest, session('admin_id'), $request->catatan);
        return redirect()->back()->with('success', 'Cuti berhasil disetujui.');
    }

    public function leaveReject(LeaveRequest $leaveRequest, Request $request)
    {
        $request->validate(['catatan' => 'required|string|min:5']);
        $this->leaveService->rejectCuti($leaveRequest, session('admin_id'), $request->catatan);
        return redirect()->back()->with('success', 'Cuti berhasil ditolak.');
    }

    // ===== IZIN TERLAMBAT / PULANG CEPAT =====
    public function permissionIndex(Request $request)
    {
        $query = PermissionRequest::with('employee');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'pending');
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        $permissionRequests = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.approval.permission', compact('permissionRequests'));
    }

    public function permissionApprove(PermissionRequest $permissionRequest, Request $request)
    {
        $permissionRequest->update([
            'status' => 'disetujui',
            'approved_by' => session('admin_id'),
            'catatan_approval' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Izin berhasil disetujui.');
    }

    public function permissionReject(PermissionRequest $permissionRequest, Request $request)
    {
        $request->validate(['catatan' => 'required|string|min:5']);

        $permissionRequest->update([
            'status' => 'ditolak',
            'approved_by' => session('admin_id'),
            'catatan_approval' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Izin berhasil ditolak.');
    }

    // ===== LEMBUR =====
    public function overtimeIndex(Request $request)
    {
        $query = OvertimeRequest::with('employee');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'pending');
        }

        $overtimeRequests = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.approval.overtime', compact('overtimeRequests'));
    }

    public function overtimeApprove(OvertimeRequest $overtimeRequest, Request $request)
    {
        $overtimeRequest->update([
            'status' => 'disetujui',
            'approved_by' => session('admin_id'),
            'catatan_approval' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Lembur berhasil disetujui.');
    }

    public function overtimeReject(OvertimeRequest $overtimeRequest, Request $request)
    {
        $request->validate(['catatan' => 'required|string|min:5']);

        $overtimeRequest->update([
            'status' => 'ditolak',
            'approved_by' => session('admin_id'),
            'catatan_approval' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Lembur berhasil ditolak.');
    }
}
