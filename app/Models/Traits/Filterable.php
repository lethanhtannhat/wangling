<?php

namespace App\Models\Traits;

trait Filterable
{
    public function scopeFilter($query, array $filters)
    {
        // Keyword (ID or Model)
        if (!empty($filters['keyword'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('asset_id', 'like', "%{$filters['keyword']}%")
                  ->orWhere('device_model', 'like', "%{$filters['keyword']}%");
            });
        }

        // OS
        if (!empty($filters['os']) && $filters['os'] !== 'all') {
            $query->where('os', $filters['os']);
        }

        // Chip
        if (!empty($filters['chip'])) {
            $query->where('chip', 'like', "%{$filters['chip']}%");
        }

        // Memory
        if (!empty($filters['memory'])) {
            $query->where('memory', $filters['memory']);
        }

        // Storage
        if (!empty($filters['storage'])) {
            $query->where('storage', 'like', "%{$filters['storage']}%");
        }

        // Serial Number
        if (!empty($filters['serial_number'])) {
            $query->where('serial_number', 'like', "%{$filters['serial_number']}%");
        }

        // Release Year
        if (!empty($filters['release_year'])) {
            $query->where('release_year', $filters['release_year']);
        }

        // Date Range
        if (!empty($filters['from_date'])) {
            $query->whereDate('purchase_date', '>=', $filters['from_date']);
        }
        if (!empty($filters['to_date'])) {
            $query->whereDate('purchase_date', '<=', $filters['to_date']);
        }

        return $query;
    }
}
