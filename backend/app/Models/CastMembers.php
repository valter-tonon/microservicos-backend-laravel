<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CastMembers extends Model
{
    use SoftDeletes, Traits\Uuid;

    const TYPE_DIRECTOR = 0;
    const TYPE_ACTOR = 1;

    protected $fillable = [
        'type',
        'name',
        'is_active'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public $incrementing = false;
}
