<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'cab_invc';
    protected $primaryKey = 'cab_invc_uin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'cab_invc_uin',
        'invc_num',
        'cust_uin',
        'tot_amt',
        'pay_stau',
        'req_id',
    ];

    protected $casts = [
        'tot_amt' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->cab_invc_uin)) {
                $model->cab_invc_uin = (string) Str::uuid();
            }
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(CustomerProfile::class, 'cust_uin', 'cab_custmr_prfl_uin');
    }

    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class, 'req_id', 'request_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'invc_uin', 'cab_invc_uin');
    }
}
