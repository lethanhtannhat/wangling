<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use \App\Models\Traits\Sortable;

    protected $fillable = [
        'name',
        'department',
        'asset_id',
        'previous_user',
        'os_version',
        'encryption_status',
        'user_type',
        'admin_password_status',
        'account_status',
        'speedometer_score',
        'novabench_score',
    ];

    public $sortableColumns = [
        'name', 'department', 'asset_id', 'created_at',
        'os_version', 'encryption_status', 'user_type', 
        'admin_password_status', 'account_status', 
        'speedometer_score', 'novabench_score'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'asset_id');
    }
}
