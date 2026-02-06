<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'asset_id' => 'required|string|max:255|unique:assets,asset_id',
            'os' => 'required|in:Win,Mac',
            'os_version' => 'required|string|max:255',
            'encryption_status' => 'required|string|max:255',
            'user_type' => 'required|string|max:255',
            'admin_password_status' => 'required|string|max:255',
            'account_status' => 'nullable|string|max:255',
            'speedometer_score' => 'nullable|numeric|min:0',
            'novabench_score' => 'nullable|numeric|min:0',
            'device_model' => 'required|string|max:255',
            'chip' => 'required|string|max:255',
            'memory' => 'required|integer|min:0',
            'storage' => 'required|numeric|min:0',
            'serial_number' => 'required|string|max:255|unique:assets,serial_number',
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'asset_id.unique' => 'Asset ID existed. Please put another Asset ID.'
        ];
    }
}
