@if($errors->any())
<div class="rounded-md bg-red-50 p-4 mb-6">
    <h3 class="text-sm leading-5 font-medium text-red-700">
        Validation errors occurred
    </h3>
    <div class="mt-2 text-sm leading-5 text-red-700">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
            <li class="mt-1">
                {{ $error }}
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endif