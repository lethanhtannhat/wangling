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
        'release_year',
        'purchase_date',
        'notes',
    ];

    protected $sortableColumns = [
        'asset_id', 
        'os', 
        'device_model', 
        'chip',        'memory', 
        'storage', 
        'serial_number', 
        'release_year',
        'purchase_date', 
        'created_at'
    ];
}
