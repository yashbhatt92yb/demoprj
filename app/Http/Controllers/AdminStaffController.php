<?php

namespace App\Http\Controllers;

use App\Domain\Services\AdminStaffService;
use App\Models\StaffProfile;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminStaffController extends Controller
{
    protected $adminStaffService;

    public function __construct(AdminStaffService $adminStaffService)
    {
        $this->adminStaffService = $adminStaffService;
    }

    public function index()
    {
        $staff = StaffProfile::with('user')->paginate(10);
        return Inertia::render('Admin/Staff/Index', [
            'staff' => $staff,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Staff/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'frst_nm' => 'required|string|max:255',
            'lst_nm' => 'nullable|string|max:255',
            'corp_eml' => 'nullable|email|max:255',
            'mob' => 'nullable|string|max:20',
            'desig' => 'nullable|string|max:255',
            'dept' => 'nullable|string|max:255',
        ]);

        try {
            $this->adminStaffService->createStaff($validated);
            return redirect()->route('admin.staff.index')->with('success', 'Staff created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(StaffProfile $staff)
    {
        $staff->load('user');
        return Inertia::render('Admin/Staff/Show', [
            'staff' => $staff,
        ]);
    }

    public function edit(StaffProfile $staff)
    {
        $staff->load('user');
        return Inertia::render('Admin/Staff/Edit', [
            'staff' => $staff,
        ]);
    }

    public function update(Request $request, StaffProfile $staff)
    {
        $validated = $request->validate([
            'frst_nm' => 'required|string|max:255',
            'lst_nm' => 'nullable|string|max:255',
            'corp_eml' => 'nullable|email|max:255',
            'mob' => 'nullable|string|max:20',
            'desig' => 'nullable|string|max:255',
            'dept' => 'nullable|string|max:255',
        ]);

        try {
            $this->adminStaffService->updateStaff($staff, $validated);
            return redirect()->route('admin.staff.index')->with('success', 'Staff updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
