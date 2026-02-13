<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestMessage extends Model
{
    use HasFactory;

    protected $table = 'request_messages';

    protected $fillable = [
        'req_id',
        'sender_id',
        'sender_role',
        'body',
        'file_path',
        'file_name',
        'seen_by_staff_at',
        'seen_by_customer_at',
    ];

    protected $casts = [
        'seen_by_staff_at' => 'datetime',
        'seen_by_customer_at' => 'datetime',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class, 'req_id', 'request_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
