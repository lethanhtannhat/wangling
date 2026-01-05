<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use Traits\Filterable, Traits\Sortable;

    protected $fillable = [
        'asset_id',
        'os',
        'device_model',
        'chip',
        'memory',
        'storage',
        'serial_number',
        'purchase_date',
    ];

    protected $sortableColumns = [
        'asset_id', 
        'device_model', 
        'os', 
        'chip', 
        'memory', 
        'storage', 
        'serial_number', 
        'purchase_date', 
        'created_at'
    ];
}