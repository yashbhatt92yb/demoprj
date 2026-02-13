<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\ServiceRequest;
use App\Models\Service;
use App\Domain\Services\ServiceRequestService;

class CustomerController extends Controller
{
    protected $serviceRequestService;

    public function __construct(ServiceRequestService $serviceRequestService)
    {
        $this->serviceRequestService = $serviceRequestService;
    }

    public function dashboard(Request $request)
    {
        $customerProfile = $request->user()->customerProfile;

        $pendingRequests = ServiceRequest::where('customer_id', $customerProfile->cab_custmr_prfl_uin)
            ->where('current_status', 'pending')->count();

        return Inertia::render('Customer/Dashboard', [
            'pendingRequests' => $pendingRequests,
        ]);
    }

    public function index(Request $request)
    {
        $customerProfile = $request->user()->customerProfile;

        $requests = ServiceRequest::with(['service', 'assignedStaff'])
            ->where('customer_id', $customerProfile->cab_custmr_prfl_uin)
            ->paginate(10);

        return Inertia::render('Customer/Requests', [
            'requests' => $requests,
        ]);
    }

    public function create()
    {
        $services = Service::all();

        return Inertia::render('Customer/CreateRequest', [
            'services' => $services,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,service_id',
        ]);

        try {
            $this->serviceRequestService->createRequest($request->user(), $request->service_id);
            return redirect()->route('customer.requests.index')->with('success', 'Request created.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(Request $request, ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->customer_id !== $request->user()->customerProfile->cab_custmr_prfl_uin) {
            abort(403);
        }

        $serviceRequest->load(['service', 'assignedStaff', 'messages.sender']);

        return Inertia::render('Customer/RequestDetail', [
            'request' => $serviceRequest,
        ]);
    }
}
