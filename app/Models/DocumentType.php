<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DocumentType extends Model
{
    use HasFactory;

    protected $table = 'cab_doc_typ';
    protected $primaryKey = 'doc_typ_uin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'doc_typ_uin',
        'doc_typ_nm',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->doc_typ_uin)) {
                $model->doc_typ_uin = (string) Str::uuid();
            }
        });
    }
}
