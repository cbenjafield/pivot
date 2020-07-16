@component('emails.layouts.tenant')
{{-- Greeting --}}
# New {{ $form->title }} submission

A form has been submitted on **{{ $website->title }}** ({{ $website->domain() }}). See the responses below:

@foreach($form->getSubmittedFields() as $field)
**{{ $field->label }}**<br>
@if($field->type != 'form-textarea')
{{ $field->value }}
@else
{!! nl2br(e($field->value)) !!}
@endif

@endforeach

@endcomponent