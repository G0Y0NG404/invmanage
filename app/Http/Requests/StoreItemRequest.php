<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'nsn' => 'nullable|string|max:255',
            'date_acquired' => 'nullable|date',
            'warranty_status' => 'nullable|string|max:255',
            'status' => 'required|string',
            'location_battalion' => 'nullable|string|max:255',
            'location_storage' => 'nullable|string|max:255',
            'assigned_personnel' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1',
        ];
    }
}
