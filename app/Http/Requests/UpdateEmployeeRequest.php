<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    protected $errorBag = 'editEmployee';

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
            'email' => ['required', 'email', 'max:150', Rule::unique('employees', 'email')->ignore($this->route('employee'))],
            'status' => ['required', 'in:active,inactive'],
        ];
    }

    public function messages(): array
    {
        return (new StoreEmployeeRequest)->messages();
    }
}
