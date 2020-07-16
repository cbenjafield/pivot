<?php

namespace App\Http\Controllers\Tenants;

use App\ContactForm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    protected function getValidationFields(ContactForm $form)
    {
        $fields = [];

        foreach($form->fields as $field) {
            $rules = [];

            if($field->required) {
                $rules[] = 'required';
            } else {
                $rules[] = 'sometimes';
                $rules[] = 'nullable';
            }

            if($field->type == 'form-email') {
                $rules[] = 'email';
            }

            $fields[$field->name] = $rules;
        }

        return (array) $fields;
    }
    
    public function submitForm(ContactForm $form)
    {
        if(request('website')->id !== $form->site_id) {
            return response()->json([], 403);
        }

        $this->validate(request(), $this->getValidationFields($form));

        $form->send();

        return response()
                    ->json([], 200);
    }

}
