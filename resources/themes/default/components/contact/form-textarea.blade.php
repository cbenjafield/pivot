<div class="sm:grid sm:grid-cols-4 sm:gap-4 sm:items-start sm:pt-5 mb-2 form-field">
    <label for="{{ $field->id }}" class="block text-base font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
        {{ $field->label }}
    </label>
    <div class="mt-1 sm:mt-0 sm:col-span-3">
        <div class="rounded-md shadow-sm">
            <textarea name="{{ $field->name }}" rows="8" id="{{ $field->id }}" class="form-input block w-full transition duration-150 ease-in-out sm:text-base sm:leading-5"{{ $field->required ? ' required' : '' }}></textarea>
        </div>
        <span class="block text-sm text-red-600 mt-1" v-if="contactFormError('{{ $field->name }}')" v-html="contactFormError('{{ $field->name }}')"></span>
    </div>
</div>