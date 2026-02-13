<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'cab_pymt';
    protected $primaryKey = 'cab_pymt_uin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'cab_pymt_uin',
        'invc_uin',
        'txn_id',
        'pd_amt',
    ];

    protected $casts = [
        'pd_amt' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->cab_pymt_uin)) {
                $model->cab_pymt_uin = (string) Str::uuid();
            }
        });
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invc_uin', 'cab_invc_uin');
    }
}
