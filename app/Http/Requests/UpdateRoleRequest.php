<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
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
                Rule::unique('roles', 'name')
                    ->ignore($this->route('role')),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama role wajib diisi.',
            'name.string' => 'Nama role harus berupa teks.',
            'name.max' => 'Nama role maksimal 100 karakter.',
            'name.unique' => 'Nama role sudah digunakan.',
        ];
    }
}
