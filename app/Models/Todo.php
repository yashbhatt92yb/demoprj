<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Todo extends Model
{
    use HasFactory;

    protected $table = 'cab_todos';
    protected $primaryKey = 'cab_todo_uin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'cab_todo_uin',
        'tzk_ttl',
        'asn_to',
        'due_dt',
        'curr_stau',
        'tzk_desp',
        'prio',
    ];

    protected $casts = [
        'due_dt' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->cab_todo_uin)) {
                $model->cab_todo_uin = (string) Str::uuid();
            }
        });
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(StaffProfile::class, 'asn_to', 'cab_staff_prfl_uin');
    }
}
