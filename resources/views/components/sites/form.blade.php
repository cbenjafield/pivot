<form action="{{ $action }}" method="POST"{!! !empty($id) ? ' id="' . $id . '"' : '' !!}{!! !empty($ref) ? ' ref="' . $ref . '"' : '' !!}>
    <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
        <div class="px-4 py-5 bg-white sm:p-6">
            {!! $slot !!}

            @include('partials.validation')
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                <label for="title" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                    Title of Website
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <div class="max-w-xs rounded-md shadow-sm">
                        <input id="title" name="title" value="{{ old('title', $site->title) }}" required maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                    </div>
                    @error('title')
                        <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">Give this website an identifiable title e.g. Bruce's Barbers.</p>
                </div>
            </div>
            <div class="mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="organisation" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                    Organisation
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <div class="max-w-xs rounded-md shadow-sm">
                        <select id="organisation" name="organisation_id" class="block form-select w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            @foreach($organisations as $org)
                            <option value="{{ $org->id }}"{{ $org->id == old('organisation_id', $site->organisation_id) ? 'selected' : '' }}>{{ $org->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="description" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                    About <small class="text-gray-400 inline-block ml-4">optional</small>
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <div class="max-w-lg flex rounded-md shadow-sm">
                        <textarea id="description" name="description" rows="3" class="form-textarea block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">{{ old('description', $site->description) }}</textarea>
                    </div>
                    @error('description')
                        <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">Briefly describe this website.</p>
                </div>
            </div>
            <div class="mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="street_address" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                    Address <small class="text-gray-400 inline-block ml-4">optional</small>
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <p class="mb-2 text-sm text-gray-500">If you want an address to show on this website, provide it here.</p>
                    <div class="max-w-xs rounded-md shadow-sm">
                        <input id="street_address" name="street_address" maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="Street Address" value="{{ old('street_address', $site->street_address) }}" />
                        @error('street_address')
                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="max-w-xs rounded-md shadow-sm mt-2">
                        <input id="locality" name="locality" maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="Locality" value="{{ old('locality', $site->locality) }}" />
                        @error('locality')
                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="max-w-xs rounded-md shadow-sm mt-2">
                        <input id="city" name="city" maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="City" value="{{ old('city', $site->city) }}" />
                        @error('city')
                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="max-w-xs rounded-md shadow-sm mt-2">
                        <input id="postcode" name="postcode" maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="Post Code" value="{{ old('postcode', $site->postcode) }}" />
                        @error('postcode')
                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>  
            </div>
            <div class="mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="tld" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                    Website Domain
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <div class="max-w-xs rounded-md shadow-sm">
                        <input id="tld" name="tld" value="{{ old('tld', $site->tld) }}" required maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                    </div>
                    @error('tld')
                        <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">The website's domain, without the www or http(s).</p>
                </div>
            </div>
            <div class="mt-6 sm:mt-5">
                <div class="sm:border-t sm:border-gray-200 sm:pt-5">
                    <div role="group" aria-labelledby="label-email">
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-baseline">
                            <div>
                                <div class="text-base leading-6 font-medium text-gray-900 sm:text-sm sm:leading-5 sm:text-gray-700" id="label-email">
                                    Website Options
                                </div>
                            </div>
                            <div class="mt-4 sm:mt-0 sm:col-span-2">
                                <div class="max-w-lg">
                                    <div class="relative flex items-start">
                                        <div class="absolute flex items-center h-5">
                                            <input id="uses_www" name="uses_www" type="checkbox" value="1" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"{{ old('uses_www', $site->uses_www) == 1 ? 'checked' : '' }} />
                                        </div>
                                        <div class="pl-7 text-sm leading-5">
                                            <label for="uses_www" class="font-medium text-gray-700">Uses WWW</label>
                                            <p class="text-gray-500">When visitors visit this website, they will be redirected to the www version.</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <div class="relative flex items-start">
                                            <div class="absolute flex items-center h-5">
                                                <input id="uses_https" name="uses_https" type="checkbox" value="1" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"{{ old('uses_https', $site->uses_https) == 1 ? 'checked' : '' }} />
                                            </div>
                                            <div class="pl-7 text-sm leading-5">
                                                <label for="uses_https" class="font-medium text-gray-700">Uses HTTPS</label>
                                                <p class="text-gray-500">When visitors visit this website, they will be redirected to the HTTPS version.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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