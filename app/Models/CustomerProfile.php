<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class CustomerProfile extends Model
{
    use HasFactory;

    protected $table = 'cab_custmr_prfl';
    protected $primaryKey = 'cab_custmr_prfl_uin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'cab_custmr_prfl_uin',
        'user_id',
        'cab_aff_uin',
        'adhr_num',
        'pn_num',
        'mob',
        'eml',
        'by_aff',
        'stau',
        'is_vf',
        'dob',
        'gender',
        'addr_line1',
        'addr_line2',
        'city',
        'state',
        'pincode',
        'deactivation_reason',
        'deactivated_at',
    ];

    protected $casts = [
        'by_aff' => 'boolean',
        'stau' => 'integer',
        'is_vf' => 'boolean',
        'dob' => 'date',
        'deactivated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->cab_custmr_prfl_uin)) {
                $model->cab_custmr_prfl_uin = (string) Str::uuid();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class, 'cab_aff_uin', 'cab_aff_uin');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(CustomerDocument::class, 'cab_custmr_uin', 'cab_custmr_prfl_uin');
    }

    public function occupation(): HasOne
    {
        return $this->hasOne(CustomerOccupation::class, 'cab_custmr_uin', 'cab_custmr_prfl_uin');
    }

    public function financialInfo(): HasOne
    {
        return $this->hasOne(CustomerFinancialInfo::class, 'cab_cust_uin', 'cab_custmr_prfl_uin');
    }

    // Assuming firm profile shares the same ID or is linked differently.
    // In dump, IDs matched. But no FK column.
    // I will assume simple relationship if IDs match.
    public function firmProfile(): HasOne
    {
        return $this->hasOne(FirmProfile::class, 'cab_frm_prfl_uin', 'cab_custmr_prfl_uin');
    }
}
