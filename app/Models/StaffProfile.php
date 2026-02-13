<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class StaffProfile extends Model
{
    use HasFactory;

    protected $table = 'cab_staff_prfl';
    protected $primaryKey = 'cab_staff_prfl_uin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'cab_staff_prfl_uin',
        'user_id',
        'frst_nm',
        'lst_nm',
        'corp_eml',
        'mob',
        'desig',
        'dept',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->cab_staff_prfl_uin)) {
                $model->cab_staff_prfl_uin = (string) Str::uuid();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function todos(): HasMany
    {
        return $this->hasMany(Todo::class, 'asn_to', 'cab_staff_prfl_uin');
    }

    public function meetingsHosted(): HasMany
    {
        return $this->hasMany(Meeting::class, 'host_id', 'cab_staff_prfl_uin');
    }
}
