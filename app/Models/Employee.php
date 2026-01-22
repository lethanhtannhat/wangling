<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'department',
        'team',
        'name',
        'email',
        'asset_id',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'asset_id');
    }
}
