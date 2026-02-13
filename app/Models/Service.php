<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $primaryKey = 'service_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'service_id',
        'service_nm',
        'base_price',
        'description',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->service_id)) {
                $model->service_id = (string) Str::uuid();
            }
        });
    }
}
