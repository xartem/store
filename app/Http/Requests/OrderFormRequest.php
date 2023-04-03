<?php

namespace App\Http\Requests;

use Domain\Order\Rules\PhoneNumberRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class OrderFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // dd(request()->all());
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email:dns', 'unique:users'],
            'phone' => ['required', new PhoneNumberRule()],
            'city' => ['sometimes'],
            'address' => ['sometimes'],
            'create_account' => ['boolean'],
            'password' => request()->boolean('create_account')
                ? ['required', 'confirmed', Password::defaults()]
                : ['nullable'],
            'delivery_type_id' => ['required', 'exists:delivery_types,id'],
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
        ];
    }
}
