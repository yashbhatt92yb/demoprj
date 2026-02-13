<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class CustomerFinancialInfo extends Model
{
    use HasFactory;

    protected $table = 'cab_cust_fin_info';
    protected $primaryKey = 'cab_cust_fin_info_uin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'cab_cust_fin_info_uin',
        'cab_cust_uin',
        'mnthly_incm',
        'anual_incm',
        'total_asset',
    ];

    protected $casts = [
        'mnthly_incm' => 'decimal:2',
        'anual_incm' => 'decimal:2',
        'total_asset' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->cab_cust_fin_info_uin)) {
                $model->cab_cust_fin_info_uin = (string) Str::uuid();
            }
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(CustomerProfile::class, 'cab_cust_uin', 'cab_custmr_prfl_uin');
    }
}
