<?php

namespace App\Http\Controllers;

use App\ContactForm;
use App\Http\Requests\ContactFormRequest;
use Illuminate\Http\Request;
use App\Site;
use App\Traits\ResourceViews;

class ContactController extends Controller
{
    use ResourceViews;
    
    public function index(Site $website)
    {
        $forms = $website->contactForms()->get();

        if(request()->wantsJson()) {
            return response()->json([
                'forms' => $forms
            ], 200);
        }

        return $this->view('index', compact('website', 'forms'));
    }

    public function create(Site $website)
    {
        return $this->view('create', compact('website'));
    }

    public function store(ContactFormRequest $request, Site $website)
    {
        $form = $website->contactForms()->create(array_merge(
            $request->only('title', 'email', 'webhook_url'),
            [
                'content' => json_encode($request->fields),
                'user_id' => auth()->id(),
            ]
        ));

        return response()->json([
            'redirect_url' => url("/websites/{$website->id}/contact/{$form->id}"),
        ], 201);
    }

    public function show(Site $website, ContactForm $contact)
    {
        return $this->view('edit', compact('contact', 'website'));
    }

    public function update(ContactFormRequest $request, Site $website, ContactForm $contact)
    {
        $contact->update(array_merge(
            $request->only('title', 'email', 'webhook_url'),
            [
                'content' => json_encode($request->fields),
                'user_id' => auth()->id()
            ]
        ));

        return response()->json([
            'message' => 'Successfully updated.',
        ], 200);
    }

    public function destroy(Site $website)
    {

    }

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
