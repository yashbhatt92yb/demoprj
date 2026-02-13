<?php

namespace App\Domain\Services;

use App\Models\ServiceRequest;
use App\Models\Service;
use App\Models\User;
use App\Models\CustomerProfile;
use App\Models\Affiliate;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class ServiceRequestService
{
    public function createRequest(User $user, string $serviceId): ServiceRequest
    {
        if (!$user->isCustomer()) {
            throw ValidationException::withMessages(['role' => 'Only customers can create service requests.']);
        }

        $customerProfile = $user->customerProfile;
        if (!$customerProfile) {
            throw ValidationException::withMessages(['profile' => 'Customer profile not found.']);
        }

        $service = Service::find($serviceId);
        if (!$service) {
            throw ValidationException::withMessages(['service_id' => 'Service not found.']);
        }

        $request = new ServiceRequest();
        $request->customer_id = $customerProfile->cab_custmr_prfl_uin;
        $request->service_id = $serviceId;
        $request->current_status = 'pending';

        // Link affiliate if customer has one
        if ($customerProfile->cab_aff_uin) {
            $request->affiliate_id = $customerProfile->cab_aff_uin;
        }

        $request->save();

        return $request;
    }

    public function transitionStatus(ServiceRequest $request, string $newStatus, User $actor): ServiceRequest
    {
        $currentStatus = $request->current_status;

        // Transitions map: current -> allowed new
        $allowedTransitions = [
            'pending' => ['assigned'], // handled by AssignmentService usually
            'assigned' => ['in_progress'],
            'in_progress' => ['needs_info', 'reviewing', 'completed', 'flagged_revoke'],
            'needs_info' => ['in_progress', 'reviewing'],
            'reviewing' => ['completed', 'needs_info'],
            'completed' => [],
            'flagged_revoke' => [],
        ];

        // Authorization checks
        if ($actor->isCustomer()) {
            throw ValidationException::withMessages(['authorization' => 'Customers cannot alter status directly.']);
        }

        // Admin override or staff strict flow
        if ($actor->isStaff() && $request->assigned_to !== $actor->staffProfile->cab_staff_prfl_uin) {
             // If not assigned to this staff, maybe admin?
             if (!$actor->isAdmin()) {
                 throw ValidationException::withMessages(['authorization' => 'You are not assigned to this request.']);
             }
        }

        if (!in_array($newStatus, $allowedTransitions[$currentStatus] ?? [])) {
             throw ValidationException::withMessages(['status' => "Invalid status transition from {$currentStatus} to {$newStatus}."]);
        }

        $request->current_status = $newStatus;
        $request->save();

        // Dispatch events here (e.g. notify customer)

        return $request;
    }
}
