<?php

namespace App\Http\Controllers;

use App\Domain\Services\AdminAffiliateService;
use App\Models\Affiliate;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminAffiliateController extends Controller
{
    protected $adminAffiliateService;

    public function __construct(AdminAffiliateService $adminAffiliateService)
    {
        $this->adminAffiliateService = $adminAffiliateService;
    }

    public function index()
    {
        $affiliates = Affiliate::with('user')->paginate(10);
        return Inertia::render('Admin/Affiliates/Index', [
            'affiliates' => $affiliates,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Affiliates/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'fa_nm' => 'required|string|max:255',
            'la_nm' => 'nullable|string|max:255',
            'adhr_num' => 'nullable|string|max:20',
            'pn_num' => 'nullable|string|max:20',
            'mob' => 'nullable|string|max:20',
            'eml' => 'nullable|email|max:255',
        ]);

        try {
            $this->adminAffiliateService->createAffiliate($validated);
            return redirect()->route('admin.affiliates.index')->with('success', 'Affiliate created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(Affiliate $affiliate)
    {
        $affiliate->load('user');
        return Inertia::render('Admin/Affiliates/Show', [
            'affiliate' => $affiliate,
        ]);
    }

    public function edit(Affiliate $affiliate)
    {
        $affiliate->load('user');
        return Inertia::render('Admin/Affiliates/Edit', [
            'affiliate' => $affiliate,
        ]);
    }

    public function update(Request $request, Affiliate $affiliate)
    {
        $validated = $request->validate([
            'fa_nm' => 'required|string|max:255',
            'la_nm' => 'nullable|string|max:255',
            'adhr_num' => 'nullable|string|max:20',
            'pn_num' => 'nullable|string|max:20',
            'mob' => 'nullable|string|max:20',
            'eml' => 'nullable|email|max:255',
        ]);

        try {
            $this->adminAffiliateService->updateAffiliate($affiliate, $validated);
            return redirect()->route('admin.affiliates.index')->with('success', 'Affiliate updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function verify(Request $request, Affiliate $affiliate)
    {
        $request->validate([
            'is_vf' => 'required|boolean',
        ]);

        try {
            $this->adminAffiliateService->verifyAffiliate($affiliate, $request->is_vf);
            return redirect()->back()->with('success', 'Affiliate verification status updated.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
