<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Services\LeaveService;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function __construct(private LeaveService $leaveService) {}

    public function index()
    {
        $leaveRequests = LeaveRequest::where('employee_id', session('employee_id'))
            ->with('leaveType')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('employee.leave.index', compact('leaveRequests'));
    }

    public function create()
    {
        $leaveTypes = LeaveType::where('is_active', true)->get();
        $balances = LeaveBalance::where('employee_id', session('employee_id'))
            ->where('tahun', now()->year)
            ->with('leaveType')
            ->get();

        return view('employee.leave.create', compact('leaveTypes', 'balances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|min:10',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $employee = Employee::find(session('employee_id'));

        $data = $request->only(['leave_type_id', 'tanggal_mulai', 'tanggal_selesai', 'alasan']);

        if ($request->hasFile('lampiran')) {
            $data['lampiran'] = $request->file('lampiran')->store('lampiran-cuti', 'public');
        }

        $result = $this->leaveService->ajukanCuti($employee, $data);

        if (!$result['success']) {
            return back()->with('error', $result['message'])->withInput();
        }

        return redirect()->route('employee.leave.index')->with('success', $result['message']);
    }

    public function balance()
    {
        $balances = LeaveBalance::where('employee_id', session('employee_id'))
            ->where('tahun', now()->year)
            ->with('leaveType')
            ->get();

        return view('employee.leave.balance', compact('balances'));
    }
}
