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
        'google_2fa_status',
        'asset_id',
        'os_version',
        'encryption_status',
        'user_type',
        'admin_password_status',
        'account_status',
        'speedometer_score',
        'notes',
    ];

    public $sortableColumns = [
        'department', 'team', 'name', 'email', 'google_2fa_status',
        'asset_id', 'os_version', 'encryption_status', 'user_type', 
        'admin_password_status', 'account_status', 
        'speedometer_score', 'notes',
        'created_at'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'asset_id');
    }
}
