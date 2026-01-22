<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait HandlesValidation
{
    /**
     * Common method to check uniqueness of a field for any model
     */
    protected function performUniqueCheck(Request $request, $modelClass)
    {
        $field = $request->query('field');
        $value = $request->query('value');
        $currentId = $request->query('current_id');

        if (!$field || !$value) {
            return response()->json(['exists' => false]);
        }

        $exists = $modelClass::where($field, $value)
            ->when($currentId, function ($query) use ($currentId) {
                return $query->where('id', '!=', $currentId);
            })
            ->exists();

        return response()->json(['exists' => $exists]);
    }
}
