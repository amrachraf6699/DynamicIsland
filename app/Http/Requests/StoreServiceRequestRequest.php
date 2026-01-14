<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone_country_code' => ['nullable', 'string', 'max:10'],
            'phone_number' => ['nullable', 'string', 'max:30'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $email = $this->input('email');
            $phone = $this->input('phone_number');
            $country = $this->input('phone_country_code');

            if (empty($email) && empty($phone)) {
                $validator->errors()->add('email', 'يرجى إدخال البريد الإلكتروني أو رقم الهاتف للتواصل.');
            }

            if (!empty($phone) && empty($country)) {
                $validator->errors()->add('phone_country_code', 'يرجى إدخال مفتاح الدولة مع رقم الهاتف.');
            }
        });
    }
}
