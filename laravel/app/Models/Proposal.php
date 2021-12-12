<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proposal extends Model
{
    use HasFactory;

    protected $table = 'proposal';
    protected $guarded = [];
    /**
     * On Creating model generate UUID
     *
     */
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string)Str::orderedUuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
