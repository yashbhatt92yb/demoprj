<?php

namespace App\Domain\Services;

use App\Models\CustomerProfile;
use App\Models\CustomerDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class AdminCustomerService
{
    public function updateCustomer(CustomerProfile $customer, array $data): CustomerProfile
    {
        return DB::transaction(function () use ($customer, $data) {
            $customer->update($data);
            return $customer;
        });
    }

    public function uploadDocument(CustomerProfile $customer, string $documentTypeId, UploadedFile $file): CustomerDocument
    {
        return DB::transaction(function () use ($customer, $documentTypeId, $file) {
            $path = $file->store('customer_documents', 'public');

            $document = CustomerDocument::create([
                'cab_custmr_uin' => $customer->cab_custmr_prfl_uin,
                'doc_typ_uin' => $documentTypeId,
                'doc_path' => $path,
                'stau' => 1, // Active status by default
            ]);

            return $document;
        });
    }
}
