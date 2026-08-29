<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskPriorityRequest extends FormRequest
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
            'code' => ['required', 'string', 'max:30', 'alpha_dash', 'unique:task_priorities,code'],
            'name' => ['required', 'string', 'max:100'],
            'color' => ['nullable', 'string', 'max:30'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['code' => strtolower((string) $this->input('code'))]);
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Kode prioritas wajib diisi.',
            'code.alpha_dash' => 'Kode hanya boleh berisi huruf, angka, tanda hubung, atau garis bawah.',
            'code.unique' => 'Kode prioritas sudah digunakan.',
            'name.required' => 'Nama prioritas wajib diisi.',
            'sort_order.required' => 'Urutan wajib diisi.',
            'sort_order.min' => 'Urutan tidak boleh kurang dari 0.',
        ];
    }
}
