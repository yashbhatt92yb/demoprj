<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Affiliate extends Model
{
    use HasFactory;

    protected $table = 'cab_aff';
    protected $primaryKey = 'cab_aff_uin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'cab_aff_uin',
        'user_id',
        'fa_nm',
        'la_nm',
        'adhr_num',
        'pn_num',
        'mob',
        'eml',
        'deactivation_reason',
        'deactivated_at',
        'removed_at',
    ];

    protected $casts = [
        'deactivated_at' => 'datetime',
        'removed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->cab_aff_uin)) {
                $model->cab_aff_uin = (string) Str::uuid();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function audits(): HasMany
    {
        return $this->hasMany(AffiliateAudit::class, 'affiliate_uin', 'cab_aff_uin');
    }
}
