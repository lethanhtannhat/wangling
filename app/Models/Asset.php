<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use Traits\Filterable, Traits\Sortable;

    protected $fillable = [
        'asset_id',
        'os',
        'os_version',
        'encryption_status',
        'user_type',
        'admin_password_status',
        'account_status',
        'speedometer_score',
        'novabench_score',
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
        'os_version',
        'device_model', 
        'encryption_status',
        'user_type',
        'admin_password_status',
        'account_status',
        'speedometer_score',
        'novabench_score',
        'chip', 
        'memory', 
        'storage', 
        'serial_number', 
        'release_year',
        'purchase_date', 
        'created_at'
    ];
}
