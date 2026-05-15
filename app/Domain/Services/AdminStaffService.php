<?php

namespace App\Domain\Services;

use App\Models\User;
use App\Models\StaffProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminStaffService
{
    public function createStaff(array $data): StaffProfile
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => User::ROLE_STAFF,
                'stau' => 1,
            ]);

            $staff = StaffProfile::create([
                'user_id' => $user->id,
                'frst_nm' => $data['frst_nm'],
                'lst_nm' => $data['lst_nm'] ?? null,
                'corp_eml' => $data['corp_eml'] ?? null,
                'mob' => $data['mob'] ?? null,
                'desig' => $data['desig'] ?? null,
                'dept' => $data['dept'] ?? null,
            ]);

            return $staff;
        });
    }

    public function updateStaff(StaffProfile $staff, array $data): StaffProfile
    {
        return DB::transaction(function () use ($staff, $data) {
            $staff->update($data);
            return $staff;
        });
    }
}
