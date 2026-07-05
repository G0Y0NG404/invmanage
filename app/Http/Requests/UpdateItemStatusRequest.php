<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateItemStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|string',
            'location_battalion' => 'nullable|string',
            'location_storage' => 'nullable|string',
            'assigned_personnel' => 'nullable|string',
        ];
    }
}
