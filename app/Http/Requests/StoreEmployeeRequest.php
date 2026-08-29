<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeeRequest extends FormRequest
{
    protected $errorBag = 'createEmployee';

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
            'name' => ['required', 'string', 'max:150'],
            'department_id' => ['required', 'exists:departments,id'],
            'position_id' => [
                'required',
                Rule::exists('positions', 'id')->where('department_id', $this->department_id),
            ],
            'email' => ['required', 'email', 'max:150', 'unique:employees,email'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama karyawan wajib diisi.',
            'department_id.required' => 'Departemen wajib dipilih.',
            'department_id.exists' => 'Departemen tidak valid.',
            'position_id.required' => 'Posisi wajib dipilih.',
            'position_id.exists' => 'Posisi harus berasal dari departemen yang dipilih.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ];
    }
}
