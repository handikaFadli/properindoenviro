<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepartmentRequest extends FormRequest
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

                Rule::unique('departments', 'name')
                    ->ignore($this->route('department')),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama departemen wajib diisi.',
            'name.string'   => 'Nama departemen harus berupa teks.',
            'name.unique'   => 'Nama departemen sudah digunakan.',
        ];
    }
}
