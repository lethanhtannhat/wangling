<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssetRequest extends FormRequest
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
            'asset_id' => [
                'required', 'string', 'max:255',
                \Illuminate\Validation\Rule::unique('assets', 'asset_id')->ignore($this->route('asset')->id),
            ],
            'os' => 'required|in:Win,Mac',
            'device_model' => 'required|string|max:255',
            'chip' => 'required|string|max:255',
            'memory' => 'required|integer|min:0',
            'storage' => 'required|numeric|min:0',
            'serial_number' => [
                'required', 'string', 'max:255',
                \Illuminate\Validation\Rule::unique('assets', 'serial_number')->ignore($this->route('asset')->id),
            ],
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
