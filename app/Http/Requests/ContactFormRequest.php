<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'email' => ['sometimes', 'required_without:webhook_url', 'nullable', 'string', 'max:255'],
            'webhook_url' => ['sometimes', 'required_without:email', 'nullable', 'string', 'max:255'],
            'fields' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
