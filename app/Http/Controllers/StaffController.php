<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\ServiceRequest;
use App\Models\Todo;
use App\Domain\Services\ServiceRequestService;
use App\Domain\Services\RequestChatService;

class StaffController extends Controller
{
    protected $requestService;
    protected $chatService;

    public function __construct(ServiceRequestService $requestService, RequestChatService $chatService)
    {
        $this->requestService = $requestService;
        $this->chatService = $chatService;
    }

    public function dashboard(Request $request)
    {
        $staffProfile = $request->user()->staffProfile;

        $assignedCount = ServiceRequest::where('assigned_to', $staffProfile->cab_staff_prfl_uin)->count();
        $pendingTodos = Todo::where('asn_to', $staffProfile->cab_staff_prfl_uin)->where('curr_stau', 'pending')->count();

        return Inertia::render('Staff/Dashboard', [
            'assignedCount' => $assignedCount,
            'pendingTodos' => $pendingTodos,
        ]);
    }

    public function assignedRequests(Request $request)
    {
        $staffProfile = $request->user()->staffProfile;
        $requests = ServiceRequest::with(['customer', 'service'])
            ->where('assigned_to', $staffProfile->cab_staff_prfl_uin)
            ->paginate(10);

        return Inertia::render('Staff/Requests', [
            'requests' => $requests,
        ]);
    }

    public function showRequest(Request $request, ServiceRequest $serviceRequest)
    {
        $user = $request->user();

        // Check if the user is an admin or the assigned staff member
        $isAssigned = $user->isStaff() &&
            $user->staffProfile &&
            $serviceRequest->assigned_to === $user->staffProfile->cab_staff_prfl_uin;

        if (!$user->isAdmin() && !$isAssigned) {
            abort(403, 'You are not authorized to view this request.');
        }

        $serviceRequest->load(['customer', 'service', 'messages.sender']);

        return Inertia::render('Staff/RequestDetail', [
            'request' => $serviceRequest,
        ]);
    }

    public function updateStatus(Request $request, ServiceRequest $serviceRequest)
    {
        $request->validate(['status' => 'required|string']);

        try {
            $this->requestService->transitionStatus($serviceRequest, $request->status, $request->user());
            return redirect()->back()->with('success', 'Status updated.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function toggleChat(Request $request, ServiceRequest $serviceRequest)
    {
        $request->validate(['enabled' => 'required|boolean']);

        try {
            $this->chatService->toggleChat($serviceRequest, $request->user(), $request->enabled);
            return redirect()->back()->with('success', 'Chat status updated.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
