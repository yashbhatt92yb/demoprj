<?php

namespace Tests\Feature\Security;

use App\Models\User;
use App\Models\StaffProfile;
use App\Models\CustomerProfile;
use App\Models\Service;
use App\Models\ServiceRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffRequestAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_cannot_view_unassigned_request(): void
    {
        // 1. Setup two staff users
        $user1 = User::factory()->create(['role' => User::ROLE_STAFF]);
        $staff1 = StaffProfile::create([
            'user_id' => $user1->id,
            'corp_eml' => 'staff1@example.com',
            'mob' => '1234567890',
            'desig' => 'Manager',
            'dept' => 'Sales'
        ]);

        $user2 = User::factory()->create(['role' => User::ROLE_STAFF]);
        $staff2 = StaffProfile::create([
            'user_id' => $user2->id,
            'corp_eml' => 'staff2@example.com',
            'mob' => '0987654321',
            'desig' => 'Developer',
            'dept' => 'IT'
        ]);

        // 2. Setup a customer and a service
        $customerUser = User::factory()->create(['role' => User::ROLE_CUSTOMER]);
        $customer = CustomerProfile::create([
            'user_id' => $customerUser->id,
            'mob' => '1122334455',
            'eml' => 'customer1@example.com'
        ]);

        $service = Service::create([
            'service_nm' => 'Test Service',
            'description' => 'Test Description',
            'base_price' => 100
        ]);

        // 3. Create a request assigned to staff 1
        $serviceRequest = ServiceRequest::create([
            'customer_id' => $customer->cab_custmr_prfl_uin,
            'service_id' => $service->service_id,
            'current_status' => 'assigned',
            'assigned_to' => $staff1->cab_staff_prfl_uin
        ]);

        // 4. Verify staff 1 can access it
        $this->actingAs($user1)
            ->get(route('staff.requests.show', $serviceRequest))
            ->assertOk();

        // 5. Verify staff 2 cannot access it
        $this->actingAs($user2)
            ->get(route('staff.requests.show', $serviceRequest))
            ->assertStatus(403);
    }
}
