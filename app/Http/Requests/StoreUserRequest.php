<?php

namespace App\Http\Requests;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'employee_id' => [
                'required',
                'integer',
                'exists:employees,id',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ];
    }


    public function after(): array
    {
        return [
            function ($validator) {

                /*
                |--------------------------------------------------------------------------
                | Cek Employee
                |--------------------------------------------------------------------------
                */

                if ($this->filled('employee_id')) {

                    $employee = Employee::query()
                        ->where(
                            'id',
                            $this->employee_id
                        )
                        ->where(
                            'status',
                            'active'
                        )
                        ->first();


                    if (!$employee) {

                        $validator
                            ->errors()
                            ->add(
                                'employee_id',
                                'Karyawan tidak aktif atau tidak tersedia.'
                            );

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Cek akun existing
                    |--------------------------------------------------------------------------
                    */

                    $existingUser = User::withTrashed()
                        ->where(
                            'employee_id',
                            $employee->id
                        )
                        ->first();


                    /*
                    |--------------------------------------------------------------------------
                    | Jika akun masih aktif
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $existingUser
                        && !$existingUser->trashed()
                    ) {

                        $validator
                            ->errors()
                            ->add(
                                'employee_id',
                                'Karyawan tersebut sudah memiliki akun.'
                            );
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | Cek Email
                |--------------------------------------------------------------------------
                */

                if ($this->filled('email')) {

                    $emailQuery = User::withTrashed()
                        ->where(
                            'email',
                            $this->email
                        );


                    /*
                    | Jika sedang restore akun employee yang sama,
                    | email miliknya sendiri boleh digunakan.
                    */

                    if ($this->filled('employee_id')) {

                        $emailQuery->where(
                            'employee_id',
                            '!=',
                            $this->employee_id
                        );
                    }


                    if ($emailQuery->exists()) {

                        $validator
                            ->errors()
                            ->add(
                                'email',
                                'Email sudah digunakan oleh akun lain.'
                            );
                    }
                }
            },
        ];
    }
}
