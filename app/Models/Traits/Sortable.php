<?php

namespace App\Models\Traits;

trait Sortable
{
    public function scopeSort($query, $request)
    {
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');

        $allowedSorts = $this->sortableColumns ?? ['created_at'];
        
        if (in_array($sort, $allowedSorts) && in_array($order, ['asc', 'desc'])) {
            return $query->orderBy($sort, $order);
        }

        return $query->orderBy('created_at', 'desc');
    }
}
