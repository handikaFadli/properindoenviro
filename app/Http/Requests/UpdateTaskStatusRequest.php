<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskStatusRequest extends FormRequest
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
            'code' => ['required', 'string', 'max:30', 'alpha_dash', Rule::unique('task_statuses', 'code')->ignore($this->route('task_status'))],
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
        return (new StoreTaskStatusRequest)->messages();
    }
}
