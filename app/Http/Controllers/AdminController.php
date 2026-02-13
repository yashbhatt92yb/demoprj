<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Models\StaffProfile;
use App\Domain\Services\AssignmentService;

class AdminController extends Controller
{
    protected $assignmentService;

    public function __construct(AssignmentService $assignmentService)
    {
        $this->assignmentService = $assignmentService;
    }

    public function dashboard()
    {
        return Inertia::render('Admin/Dashboard', [
            'requestCount' => ServiceRequest::count(),
            'userCount' => User::count(),
            // Add more stats
        ]);
    }

    public function serviceRequests()
    {
        $requests = ServiceRequest::with(['customer', 'service', 'assignedStaff', 'affiliate'])->paginate(10);
        $staff = StaffProfile::where('is_available', true)->get();

        return Inertia::render('Admin/ServiceRequests', [
            'requests' => $requests,
            'availableStaff' => $staff,
        ]);
    }

    public function assignStaff(Request $request, ServiceRequest $serviceRequest)
    {
        $request->validate([
            'staff_uin' => 'required|exists:cab_staff_prfl,cab_staff_prfl_uin',
        ]);

        $staff = StaffProfile::findOrFail($request->staff_uin);

        try {
            $this->assignmentService->assignStaff($serviceRequest, $request->user(), $staff);
            return redirect()->back()->with('success', 'Staff assigned successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
