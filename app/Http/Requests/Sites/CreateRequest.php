<?php

namespace App\Http\Requests\Sites;

use App\Rules\FQDN;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
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
            'description' => ['sometimes', 'nullable', 'string', 'max:600'],
            'street_address' => ['sometimes', 'required_with:postcode', 'nullable', 'max:255'],
            'locality' => ['sometimes', 'nullable', 'max:255'],
            'city' => ['sometimes', 'nullable', 'max:255'],
            'postcode' => ['sometimes', 'required_with:street_address'],
            'organisation_id' => [
                'required',
                Rule::exists('organisations', 'id'),
            ],
            'tld' => [
                'required',
                'max:255',
                Rule::unique('sites', 'tld'),
                new FQDN,
            ]
        ];
    }
}
