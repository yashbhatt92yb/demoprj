<?php

namespace App\Domain\Services;

use App\Models\Invoice;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class InvoiceService
{
    public function createInvoice(User $actor, ServiceRequest $request, float $amount): Invoice
    {
        if (!$actor->isAdmin()) {
            throw ValidationException::withMessages(['role' => 'Only admins can generate invoices.']);
        }

        $invoice = new Invoice();
        $invoice->invc_num = 'INV-' . strtoupper(Str::random(8)); // Basic generator
        $invoice->cust_uin = $request->customer_id;
        $invoice->req_id = $request->request_id;
        $invoice->tot_amt = $amount;
        $invoice->pay_stau = 'unpaid';
        $invoice->save();

        return $invoice;
    }

    public function markPaid(Invoice $invoice, string $txnId, float $amount): Invoice
    {
        if ($amount != $invoice->tot_amt) {
             // Maybe allow partial? For now strict.
             throw ValidationException::withMessages(['amount' => 'Payment amount does not match invoice amount.']);
        }

        $invoice->pay_stau = 'paid';
        $invoice->save();

        // Create Payment record
        $invoice->payments()->create([
            'txn_id' => $txnId,
            'pd_amt' => $amount,
        ]);

        return $invoice;
    }
}
