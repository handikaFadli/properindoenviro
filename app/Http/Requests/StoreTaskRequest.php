<?php

namespace App\Http\Requests;

use App\Models\Employee;
use App\Models\TaskPriority;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title' => [
                'required',
                'string',
                'max:150',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'pic_id' => [
                'required',
                'integer',
                'exists:employees,id',
            ],

            'deadline' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'task_priority_id' => [
                'required',
                'integer',
                'exists:task_priorities,id',
            ],
        ];
    }

    public function after(): array
    {
        return [

            function ($validator) {

                /*
                |--------------------------------------------------------------------------
                | Validasi PIC Aktif
                |--------------------------------------------------------------------------
                */

                if ($this->filled('pic_id')) {

                    $employeeExists = Employee::query()
                        ->where('id', $this->pic_id)
                        ->where('status', 'active')
                        ->exists();

                    if (!$employeeExists) {

                        $validator
                            ->errors()
                            ->add(
                                'pic_id',
                                'PIC yang dipilih tidak aktif atau tidak tersedia.'
                            );
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | Validasi Prioritas Aktif
                |--------------------------------------------------------------------------
                */

                if ($this->filled('task_priority_id')) {

                    $priorityExists = TaskPriority::query()
                        ->where('id', $this->task_priority_id)
                        ->where('is_active', true)
                        ->exists();

                    if (!$priorityExists) {

                        $validator
                            ->errors()
                            ->add(
                                'task_priority_id',
                                'Prioritas yang dipilih tidak aktif atau tidak tersedia.'
                            );
                    }
                }
            },

        ];
    }

    public function messages(): array
    {
        return [
            'title.required' =>
            'Judul tugas wajib diisi.',

            'title.max' =>
            'Judul tugas maksimal 150 karakter.',

            'pic_id.required' =>
            'PIC wajib dipilih.',

            'pic_id.exists' =>
            'PIC yang dipilih tidak ditemukan.',

            'deadline.required' =>
            'Deadline wajib diisi.',

            'deadline.date' =>
            'Format deadline tidak valid.',

            'deadline.after_or_equal' =>
            'Deadline tidak boleh sebelum hari ini.',

            'task_priority_id.required' =>
            'Prioritas wajib dipilih.',

            'task_priority_id.exists' =>
            'Prioritas yang dipilih tidak ditemukan.',
        ];
    }
}
