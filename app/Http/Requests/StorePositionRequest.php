<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePositionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'department_id' => ['required', 'exists:departments,id'],
            'role_id' => ['required', 'exists:roles,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama posisi wajib diisi.',
            'name.string' => 'Nama posisi harus berupa teks.',
            'name.max' => 'Nama posisi maksimal 100 karakter.',
            'department_id.required' => 'Departemen wajib dipilih.',
            'department_id.exists' => 'Departemen tidak valid.',
            'role_id.required' => 'Role wajib dipilih.',
            'role_id.exists' => 'Role tidak valid.',
        ];
    }
}
