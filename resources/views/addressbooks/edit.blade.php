<!DOCTYPE html>
<html>

<head>
    <title>Edit Address Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-4">
        <div class="card shadow text-dark bg-white">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-0">Edit Address Book</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('addressbooks.update', $addressBook->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="action" value="update">

                    <div class="row">
                        {{-- Contact Type --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Type</label>
                            <select name="contact_type" class="form-select @error('contact_type') is-invalid @else @if($errors->any()) is-valid @endif @enderror">
                                <option value="">Select Contact Type</option>
                                <option value="Customer" {{ old('contact_type', $addressBook->contact_type) == 'Customer' ? 'selected' : '' }}>Customer</option>
                                <option value="Vendor" {{ old('contact_type', $addressBook->contact_type) == 'Vendor' ? 'selected' : '' }}>Vendor</option>
                                <option value="Employee" {{ old('contact_type', $addressBook->contact_type) == 'Employee' ? 'selected' : '' }}>Employee</option>
                                <option value="Site" {{ old('contact_type', $addressBook->contact_type) == 'Site' ? 'selected' : '' }}>Site</option>
                            </select>
                            @error('contact_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Name --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @else @if($errors->any()) is-valid @endif @enderror" value="{{ old('name', $addressBook->name) }}" placeholder="Enter Name">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Mobile No --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mobile No</label>
                            <input type="text" name="mobile_no" class="form-control @error('mobile_no') is-invalid @else @if($errors->any()) is-valid @endif @enderror" value="{{ old('mobile_no', $addressBook->mobile) }}" placeholder="Enter Mobile No">
                            @error('mobile_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alternate Mobile --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Alternate Mobile</label>
                            <input type="text" name="alternate_mobile" class="form-control @error('alternate_mobile') is-invalid @else @if($errors->any()) is-valid @endif @enderror" value="{{ old('alternate_mobile', $addressBook->alternate_mobile) }}" placeholder="Enter Alternate Mobile">
                            @error('alternate_mobile')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Email --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @else @if($errors->any()) is-valid @endif @enderror" value="{{ old('email', $addressBook->email) }}" placeholder="Enter Email">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Country --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Country</label>
                            <select name="country_id" id="countrySelect" class="form-select @error('country_id') is-invalid @else @if($errors->any()) is-valid @endif @enderror">
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id', $addressBook->country_id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->country }}
                                </option>
                                @endforeach
                            </select>
                            @error('country_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- State --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">State</label>
                            <select name="state_id" id="stateSelect" class="form-select @error('state_id') is-invalid @else @if($errors->any()) is-valid @endif @enderror">
                                <option value="">Select State</option>
                            </select>
                            @error('state_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- City --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <select name="city_id" id="citySelect" class="form-select @error('city_id') is-invalid @else @if($errors->any()) is-valid @endif @enderror">
                                <option value="">Select City</option>
                            </select>
                            @error('city_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Area --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Area</label>
                            <select name="area_id" id="areaSelect" class="form-select @error('area_id') is-invalid @else @if($errors->any()) is-valid @endif @enderror">
                                <option value="">Select Area</option>
                            </select>
                            @error('area_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Pincode --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pincode</label>
                            <input type="text" name="pincode" id="pincode" class="form-control @error('pincode') is-invalid @else @if($errors->any()) is-valid @endif @enderror" value="{{ old('pincode', $addressBook->pincode) }}" placeholder="Enter Pincode">
                            @error('pincode')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Address Line 1 --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address Line 1</label>
                            <textarea name="address_line_1" class="form-control @error('address_line_1') is-invalid @else @if($errors->any()) is-valid @endif @enderror" placeholder="Enter Address Line 1">{{ old('address_line_1', $addressBook->address1) }}</textarea>
                            @error('address_line_1')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Address Line 2 --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address Line 2</label>
                            <textarea name="address_line_2" class="form-control @error('address_line_2') is-invalid @else @if($errors->any()) is-valid @endif @enderror" placeholder="Enter Address Line 2">{{ old('address_line_2', $addressBook->address2) }}</textarea>
                            @error('address_line_2')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Landmark --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Landmark</label>
                            <input type="text" name="landmark" class="form-control @error('landmark') is-invalid @else @if($errors->any()) is-valid @endif @enderror" value="{{ old('landmark', $addressBook->landmark) }}" placeholder="Enter Landmark">
                            @error('landmark')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Default Address --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Default Address</label>
                            <select name="is_default_address" class="form-select @error('is_default_address') is-invalid @else @if($errors->any()) is-valid @endif @enderror">
                                <option value="0" {{ old('is_default_address', $addressBook->is_default) == '0' ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('is_default_address', $addressBook->is_default) == '1' ? 'selected' : '' }}>Yes</option>
                            </select>
                            @error('is_default_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-start gap-2 mt-3">
                        <button type="submit" class="btn btn-warning">
                            Update
                        </button>
                        <a href="{{ route('addressbooks.index') }}" class="btn btn-secondary">
                            Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countrySelect = document.getElementById('countrySelect');
            const stateSelect = document.getElementById('stateSelect');
            const citySelect = document.getElementById('citySelect');
            const areaSelect = document.getElementById('areaSelect');
            const pincodeInput = document.getElementById('pincode');

            // Store old values or fall back to database values
            const selectedStateId = "{{ old('state_id', $addressBook->state_id) }}";
            const selectedCityId = "{{ old('city_id', $addressBook->city_id) }}";
            const selectedAreaId = "{{ old('area_id', $addressBook->area_id) }}";

            // Flag to track if we are in initial load (to pass saved IDs through cascade)
            let isInitialLoad = true;

            // Trigger state loading when country changes
            countrySelect.addEventListener('change', function() {
                const countryId = this.value;
                clearSelect(stateSelect, 'State');
                clearSelect(citySelect, 'City');
                clearSelect(areaSelect, 'Area');

                if (countryId) {
                    fetchStates(countryId);
                }
            });

            // Trigger city loading when state changes
            stateSelect.addEventListener('change', function() {
                const stateId = this.value;
                clearSelect(citySelect, 'City');
                clearSelect(areaSelect, 'Area');

                if (stateId) {
                    // During initial load, pass the saved city ID so it gets pre-selected
                    fetchCities(stateId, isInitialLoad ? selectedCityId : '');
                }
            });

            // Trigger area loading when city changes
            citySelect.addEventListener('change', function() {
                const cityId = this.value;
                clearSelect(areaSelect, 'Area');

                if (cityId) {
                    // During initial load, pass the saved area ID so it gets pre-selected
                    fetchAreas(cityId, isInitialLoad ? selectedAreaId : '');
                }
            });

            // Trigger pincode autofill when area changes
            areaSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const pincode = selectedOption.getAttribute('data-pincode') || '';
                if (pincode) {
                    pincodeInput.value = pincode;
                }
            });

            // Helper functions
            function clearSelect(selectElement, typeName) {
                selectElement.innerHTML = `<option value="">Select ${typeName}</option>`;
            }

            function fetchStates(countryId, selectId = '') {
                fetch(`/api/countries/${countryId}/states`)
                    .then(res => res.json())
                    .then(data => {
                        clearSelect(stateSelect, 'State');
                        data.forEach(state => {
                            const selected = selectId == state.id ? 'selected' : '';
                            stateSelect.insertAdjacentHTML('beforeend', `<option value="${state.id}" ${selected}>${state.state}</option>`);
                        });
                        if (selectId) {
                            stateSelect.dispatchEvent(new Event('change'));
                        }
                    });
            }

            function fetchCities(stateId, selectId = '') {
                fetch(`/api/states/${stateId}/cities`)
                    .then(res => res.json())
                    .then(data => {
                        clearSelect(citySelect, 'City');
                        data.forEach(city => {
                            const selected = selectId == city.id ? 'selected' : '';
                            citySelect.insertAdjacentHTML('beforeend', `<option value="${city.id}" ${selected}>${city.city}</option>`);
                        });
                        if (selectId) {
                            citySelect.dispatchEvent(new Event('change'));
                        }
                    });
            }

            function fetchAreas(cityId, selectId = '') {
                fetch(`/api/cities/${cityId}/areas`)
                    .then(res => res.json())
                    .then(data => {
                        clearSelect(areaSelect, 'Area');
                        data.forEach(area => {
                            const selected = selectId == area.id ? 'selected' : '';
                            areaSelect.insertAdjacentHTML('beforeend', `<option value="${area.id}" data-pincode="${area.pincode || ''}" ${selected}>${area.area}</option>`);
                        });
                        // After areas are loaded, initial cascade is complete
                        isInitialLoad = false;
                    });
            }

            // Initialize dropdowns matching database / old values on page load
            if (countrySelect.value) {
                fetchStates(countrySelect.value, selectedStateId);
            }
        });
    </script>

</body>

</html>