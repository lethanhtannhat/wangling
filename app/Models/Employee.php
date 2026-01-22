<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use \App\Models\Traits\Sortable;

    protected $fillable = [
        'department',
        'team',
        'name',
        'email',
        'asset_id',
    ];

    public $sortableColumns = ['department', 'team', 'name', 'email', 'asset_id', 'os', 'device_model', 'created_at'];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'asset_id');
    }
}
