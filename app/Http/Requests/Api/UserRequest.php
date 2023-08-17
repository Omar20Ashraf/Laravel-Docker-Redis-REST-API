<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator):void
    {

        $response = new JsonResponse([
            'status' => false,
            'message' => $validator->errors()->first(),
            'errors' => $validator->errors(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules= [
            'name' => 'required|string|max:225',
        ];

        if ($this->isMethod('post')) {
            $rules += [
                'email' => 'required|email|max:225|unique:users,email,except,id',
                'password' => 'required|string|min:8'
            ];
        } else {
            $rules += [
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore(request('user')->id)],
                'password' => 'nullable|string|min:8'
            ];
        }

        return $rules;
    }

    /**
     * Get custom attribute names for validation errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        // code...
        return [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }
}
