<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class CustomerDocument extends Model
{
    use HasFactory;

    protected $table = 'cab_custmr_doc';
    protected $primaryKey = 'cab_custmr_doc_uin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'cab_custmr_doc_uin',
        'cab_custmr_uin',
        'doc_typ_uin',
        'doc_path',
        'stau',
    ];

    protected $casts = [
        'stau' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->cab_custmr_doc_uin)) {
                $model->cab_custmr_doc_uin = (string) Str::uuid();
            }
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(CustomerProfile::class, 'cab_custmr_uin', 'cab_custmr_prfl_uin');
    }

    public function documentType(): BelongsTo
    {
        // doc_typ_uin is in cab_doc_typ. I haven't created DocumentType model yet.
        return $this->belongsTo(DocumentType::class, 'doc_typ_uin', 'doc_typ_uin');
    }
}
