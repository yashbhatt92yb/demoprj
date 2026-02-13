<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class FirmProfile extends Model
{
    use HasFactory;

    protected $table = 'cab_frm_prfl';
    protected $primaryKey = 'cab_frm_prfl_uin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'cab_frm_prfl_uin',
        'frm_nm',
        'reg_nbr',
        'gst_nbr',
        'bizz_typ',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->cab_frm_prfl_uin)) {
                $model->cab_frm_prfl_uin = (string) Str::uuid();
            }
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(CustomerProfile::class, 'cab_frm_prfl_uin', 'cab_custmr_prfl_uin');
    }
}
