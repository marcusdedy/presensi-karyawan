<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;

class DashboardController extends Controller
{
    public function __construct(private ReportService $reportService) {}

    public function index()
    {
        $stats = $this->reportService->getDashboardStats();
        $monthlyStats = $this->reportService->getMonthlyAttendanceStats();
        $overtimeStats = $this->reportService->getOvertimeStats();
        $pendingApprovals = $this->reportService->getPendingApprovals();

        return view('admin.dashboard', compact('stats', 'monthlyStats', 'overtimeStats', 'pendingApprovals'));
    }
}
