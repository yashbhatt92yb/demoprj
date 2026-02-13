<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class CustomerOccupation extends Model
{
    use HasFactory;

    protected $table = 'cab_custmr_occup';
    protected $primaryKey = 'cab_custmr_occup_uin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'cab_custmr_occup_uin',
        'cab_custmr_uin',
        'empl_typ',
        'desig',
        'empl_info',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->cab_custmr_occup_uin)) {
                $model->cab_custmr_occup_uin = (string) Str::uuid();
            }
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(CustomerProfile::class, 'cab_custmr_uin', 'cab_custmr_prfl_uin');
    }
}
