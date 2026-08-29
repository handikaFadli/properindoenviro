<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePositionRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('positions', 'name')
                    ->where(fn ($query) => $query->where('department_id', $this->department_id))
                    ->ignore($this->route('position')),
            ],
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
            'name.unique' => 'Nama posisi sudah digunakan pada departemen ini.',
            'department_id.required' => 'Departemen wajib dipilih.',
            'department_id.exists' => 'Departemen tidak valid.',
            'role_id.required' => 'Role wajib dipilih.',
            'role_id.exists' => 'Role tidak valid.',
        ];
    }
}
