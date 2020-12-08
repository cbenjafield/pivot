<form action="{{ $action }}" method="POST"{!! !empty($id) ? ' id="' . $id . '"' : '' !!}{!! !empty($ref) ? ' ref="' . $ref . '"' : '' !!}>
    <div class="max-w-4xl mx-auto shadow sm:rounded-md sm:overflow-hidden mt-6">
        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                <label for="name" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                    Name of organisation
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <div class="max-w-xs rounded-md shadow-sm">
                        <input id="name" name="name" value="{{ old('name', $organisation->name) }}" required maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                    </div>
                    @error('name')
                        <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="description" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                    About
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <div class="max-w-lg flex rounded-md shadow-sm">
                        <textarea id="description" name="description" rows="3" class="form-textarea block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">{{ old('description', $organisation->description) }}</textarea>
                    </div>
                    @error('description')
                        <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">Write a few sentences about the organisation.</p>
                </div>
            </div>
            <div class="mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="street_address" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                    Address <small class="text-gray-400 inline-block ml-4">optional</small>
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <div class="max-w-xs rounded-md shadow-sm">
                        <input id="street_address" name="street_address" maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="Street Address" value="{{ old('street_address', $organisation->street_address) }}" />
                        @error('street_address')
                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="max-w-xs rounded-md shadow-sm mt-2">
                        <input id="locality" name="locality" maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="Locality" value="{{ old('locality', $organisation->locality) }}" />
                        @error('locality')
                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="max-w-xs rounded-md shadow-sm mt-2">
                        <input id="city" name="city" maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="City" value="{{ old('city', $organisation->city) }}" />
                        @error('city')
                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="max-w-xs rounded-md shadow-sm mt-2">
                        <input id="postcode" name="postcode" maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="Post Code" value="{{ old('postcode', $organisation->postcode) }}" />
                        @error('postcode')
                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-6 sm:mt-5 sm:border-t sm:border-gray-200 sm:pt-5">
                <h3 class="text-lg font-semibold text-gray-900">PayPal Integration</h3>
                <div class="mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                    <label for="paypal_client_id" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                        Client ID
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <div class="max-w-lg rounded-md shadow-sm">
                            <input id="paypal_client_id" name="paypal_client_id" value="{{ old('paypal_client_id', $organisation->paypal_client_id) }}" required maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                        </div>
                        @error('paypal_client_id')
                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="paypal_client_id" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                        Secret
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <div class="max-w-lg rounded-md shadow-sm">
                            <input id="paypal_client_secret" name="paypal_client_secret" value="{{ old('paypal_client_secret', $organisation->paypal_client_secret) }}" required maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                        </div>
                        @error('paypal_client_secret')
                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            @csrf
            @method($method)
            <span class="inline-flex rounded-md shadow-sm">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                    @if($method != 'POST')
                        Save
                    @else
                        Create
                    @endif
                </button>
            </span>
        </div>
    </div>
</form>