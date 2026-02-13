<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $table = 'service_requests';
    protected $primaryKey = 'request_id';

    protected $fillable = [
        'customer_id',
        'service_id',
        'affiliate_id',
        'current_status',
        'assigned_to',
        'assignment_seen_by_staff_at',
        'is_chat_enabled',
    ];

    protected $casts = [
        'assignment_seen_by_staff_at' => 'datetime',
        'is_chat_enabled' => 'boolean',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(CustomerProfile::class, 'customer_id', 'cab_custmr_prfl_uin');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class, 'affiliate_id', 'cab_aff_uin');
    }

    public function assignedStaff(): BelongsTo
    {
        return $this->belongsTo(StaffProfile::class, 'assigned_to', 'cab_staff_prfl_uin');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(RequestMessage::class, 'req_id', 'request_id');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'req_id', 'request_id');
    }
}
