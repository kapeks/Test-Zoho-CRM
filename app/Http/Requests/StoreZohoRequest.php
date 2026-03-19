<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\ZohoDealStage;
use Illuminate\Validation\Rules\Enum;

class StoreZohoRequest extends FormRequest
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
            'account_name' => ['required', 'string', 'max:255'],
            'website'      => ['nullable', 'url'],
            'phone'        => ['nullable', 'regex:/^[0-9]+$/', 'min:10', 'max:15'],
            'deal_name'    => ['required', 'string', 'max:255'],
            'stage'        => ['required', new Enum(ZohoDealStage::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'account_name.required' => 'Название аккаунта обязательно для заполнения.',
            'account_name.string'   => 'Название аккаунта должно быть строкой.',
            'account_name.max'      => 'Название аккаунта не должно превышать 255 символов.',

            'website.url'           => 'Введите корректный URL (например, https://example.com).',

            'phone.regex' => 'Поле телефон должно содержать только цифры.',
            'phone.min'   => 'Номер телефона должен содержать минимум 10 цифр.',

            'deal_name.required'    => 'Название сделки обязательно для заполнения.',
            'deal_name.max'         => 'Название сделки не должно превышать 255 символов.',

            'stage.required'        => 'Пожалуйста, выберите стадию сделки из списка.',
            'stage.Illuminate\Validation\Rules\Enum' => 'Выбранная стадия недействительна.',
        ];
    }

}

