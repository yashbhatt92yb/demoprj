<?php

namespace App\Domain\Services;

use App\Models\ServiceRequest;
use App\Models\User;
use App\Models\StaffProfile;
use Illuminate\Validation\ValidationException;

class AssignmentService
{
    public function assignStaff(ServiceRequest $request, User $adminUser, StaffProfile $staffProfile): ServiceRequest
    {
        if (!$adminUser->isAdmin()) {
            throw ValidationException::withMessages(['role' => 'Only admins can assign staff.']);
        }

        if ($request->current_status !== 'pending' && $request->current_status !== 'assigned') {
            throw ValidationException::withMessages(['status' => 'Request must be pending or already assigned to reassign.']);
        }

        if (!$staffProfile->is_available) {
            throw ValidationException::withMessages(['staff' => 'Selected staff member is not available.']);
        }

        $request->assigned_to = $staffProfile->cab_staff_prfl_uin;
        $request->current_status = 'assigned';
        $request->save();

        // Dispatch event: notify staff
        // event(new StaffAssigned($request, $staffProfile));

        return $request;
    }
}
