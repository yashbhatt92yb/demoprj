<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Meeting extends Model
{
    use HasFactory;

    protected $table = 'cab_meets';
    protected $primaryKey = 'cab_meet_uin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'cab_meet_uin',
        'meet_nm',
        'host_id',
        'sch_dt',
        'meet_link',
    ];

    protected $casts = [
        'sch_dt' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->cab_meet_uin)) {
                $model->cab_meet_uin = (string) Str::uuid();
            }
        });
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(StaffProfile::class, 'host_id', 'cab_staff_prfl_uin');
    }
}
