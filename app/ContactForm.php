<?php

namespace App;

use App\Notifications\ContactForms\ContactFormSent;
use App\Pivot\Items\Field;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ContactForm extends Model
{
    use Notifiable;

    protected $guarded = [];

    protected $with = [
        'website',
    ];

    public function website()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function getFieldsAttribute()
    {
        $jsonFields = json_decode($this->content, true);
        $fields = new Collection();

        foreach($jsonFields as $field) {
            $fields->push(new Field($field, $this->website));
        }

        return $fields;
    }

    public function getSubmittedFields()
    {
        $sortedByName = [];

        foreach($this->fields as $field) {
            $field->value = request($field->name);
            $sortedByName[$field->name] = $field;
        }

        return $sortedByName;
    }

    public function send()
    {
        if(!empty($this->webhook_url)) {
            return $this->fireWebhookEvent();
        }

        $this->notify(
            new ContactFormSent(request('website'))
        );
    }

    protected function getSubmittedFieldsKeyValues()
    {
        $fields = [];

        foreach($this->getSubmittedFields() as $field) {
            $fields[$field->name] = $field->value;
        }

        return $fields;
    }

    /**
     * Send a POST request to the webhook url with the following data:
     * -> Submitted form data
     * -> Site origin
     * -> IP Address of submission
     */
    protected function fireWebhookEvent()
    {
        $data = [
            'fields' => $this->getSubmittedFieldsKeyValues(),
            'form' => $this,
            'site_origin' => request('website')->tld,
            'ip_address' => request()->ip(),
        ];

        // dd($data);

        $response = Http::asForm()->post($this->webhook_url, $data);

        if(! $response->successful()) {
            return abort(400, 'Bad Request.');
        }

        return true;
    }
}
