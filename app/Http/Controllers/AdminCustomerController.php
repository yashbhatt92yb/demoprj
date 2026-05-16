<?php

namespace App\Http\Controllers;

use App\Domain\Services\AdminCustomerService;
use App\Models\CustomerProfile;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminCustomerController extends Controller
{
    protected $adminCustomerService;

    public function __construct(AdminCustomerService $adminCustomerService)
    {
        $this->adminCustomerService = $adminCustomerService;
    }

    public function index()
    {
        $customers = CustomerProfile::with(['user', 'affiliate'])->paginate(10);
        return Inertia::render('Admin/Customers/Index', [
            'customers' => $customers,
        ]);
    }

    public function show(CustomerProfile $customer)
    {
        $customer->load(['user', 'affiliate', 'documents.documentType']);
        $documentTypes = DocumentType::all();

        return Inertia::render('Admin/Customers/Show', [
            'customer' => $customer,
            'documentTypes' => $documentTypes,
        ]);
    }

    public function edit(CustomerProfile $customer)
    {
        $customer->load(['user']);
        return Inertia::render('Admin/Customers/Edit', [
            'customer' => $customer,
        ]);
    }

    public function update(Request $request, CustomerProfile $customer)
    {
        $validated = $request->validate([
            'mob' => 'nullable|string|max:20',
            'eml' => 'nullable|email|max:255',
            'adhr_num' => 'nullable|string|max:20',
            'pn_num' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|max:10',
            'addr_line1' => 'nullable|string|max:255',
            'addr_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
        ]);

        try {
            $this->adminCustomerService->updateCustomer($customer, $validated);
            return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function uploadDocument(Request $request, CustomerProfile $customer)
    {
        $request->validate([
            'doc_typ_uin' => 'required|exists:cab_doc_typ,doc_typ_uin',
            'document' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx',
        ]);

        try {
            $this->adminCustomerService->uploadDocument($customer, $request->doc_typ_uin, $request->file('document'));
            return redirect()->back()->with('success', 'Document uploaded successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
