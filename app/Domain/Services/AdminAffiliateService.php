<?php

namespace App\Domain\Services;

use App\Models\User;
use App\Models\Affiliate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminAffiliateService
{
    public function createAffiliate(array $data): Affiliate
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => User::ROLE_AFFILIATE,
                'stau' => 1,
            ]);

            $affiliate = Affiliate::create([
                'user_id' => $user->id,
                'fa_nm' => $data['fa_nm'],
                'la_nm' => $data['la_nm'] ?? null,
                'adhr_num' => $data['adhr_num'] ?? null,
                'pn_num' => $data['pn_num'] ?? null,
                'mob' => $data['mob'] ?? null,
                'eml' => $data['eml'] ?? null,
            ]);

            return $affiliate;
        });
    }

    public function updateAffiliate(Affiliate $affiliate, array $data): Affiliate
    {
        return DB::transaction(function () use ($affiliate, $data) {
            $affiliate->update($data);
            return $affiliate;
        });
    }

    public function verifyAffiliate(Affiliate $affiliate, bool $isVerified): void
    {
        DB::transaction(function () use ($affiliate, $isVerified) {
            $user = $affiliate->user;
            if ($user) {
                $user->update(['is_vf' => $isVerified ? 1 : 0]);
            }
        });
    }
}
