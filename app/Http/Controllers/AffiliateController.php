<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\CustomerProfile;
use App\Models\ServiceRequest;
use App\Models\AffiliateAudit;

class AffiliateController extends Controller
{
    public function dashboard(Request $request)
    {
        $affiliate = $request->user()->affiliateProfile;

        $customerCount = CustomerProfile::where('cab_aff_uin', $affiliate->cab_aff_uin)->count();
        $referrals = CustomerProfile::where('cab_aff_uin', $affiliate->cab_aff_uin)
            ->with(['requests'])
            ->get();

        $earnings = AffiliateAudit::where('affiliate_uin', $affiliate->cab_aff_uin)
            ->where('action', 'commission_paid')
            ->sum('amount');

        return Inertia::render('Affiliate/Dashboard', [
            'customerCount' => $customerCount,
            'earnings' => $earnings,
            'referrals' => $referrals,
        ]);
    }
}
