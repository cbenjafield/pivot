<div class="contact-form" id="{{ "form-{$block->id}" }}">
    <!-- {{ $renderable->title }} -->
    <form method="POST" action="{{ url("contact/{$renderable->id}") }}" class="form{{ !empty($block->className) ? ' ' . $block->className : '' }}" @submit.prevent="submitContactForm($event)" id="form-element-{{ $block->id }}">
        @foreach($renderable->fields as $field)
            {!! $field->view() !!}
        @endforeach

        <div class="sm:grid sm:grid-cols-4 sm:gap-4 mt-5">
            <div>
                
            </div>
            <div class="sm:col-span-3">
                <div class="bg-teal-100 border-t-4 border-teal-500 flex mb-5 items-stretch" v-if="successMessage('form-element-{{ $block->id }}')">
                    <div class="p-4 bg-teal-400 text-white text-3xl flex items-center justify-center">
                        <i class="far fa-check fa-fw"></i>
                    </div>
                    <div class="flex-1 flex items-center p-3" v-html="successMessage('form-element-{{ $block->id }}')"></div>
                </div>

                <div class="bg-red-100 border-t-4 border-red-600 flex mb-5 items-stretch" v-if="errorMessage('form-element-{{ $block->id }}')">
                    <div class="p-4 bg-red-500 text-white text-3xl flex items-center justify-center">
                        <i class="far fa-times fa-fw"></i>
                    </div>
                    <div class="flex-1 flex items-center p-3" v-html="successMessage('form-element-{{ $block->id }}')"></div>
                </div>

                <span class="shadow-sm rounded-md overflow-hidden">
                    <button type="submit" class="cursor-pointer px-6 py-2 bg-teal-600 text-white font-medium rounded-md hover:bg-teal-700 duration-200 transition-colors">
                        Send Message
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>