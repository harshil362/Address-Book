<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Area</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card shadow">

                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Edit Area</h4>
                    </div>

                    <div class="card-body">

                        @php
                        $selectedCountryId = request('country_id', $area->city->state->country_id);
                        $countryChanged = $selectedCountryId != $area->city->state->country_id;
                        $selectedStateId = $countryChanged ? request('state_id') : request('state_id', $area->city->state_id);
                        $stateChanged = $selectedStateId != $area->city->state_id;
                        $selectedCityId = $stateChanged ? old('city_id') : old('city_id', $area->city_id);
                        @endphp

                        {{-- Country Form --}}
                        <form action="{{ route('areas.edit', $area->id) }}" method="GET" id="countryForm">

                            <div class="mb-3">
                                <label class="form-label">Country</label>

                                <select name="country_id"
                                    class="form-select"
                                    onchange="this.form.submit()">

                                    <!-- Current country (displayed but hidden from dropdown list) -->
                                    <option value="{{ $area->city->state->country_id }}"
                                        {{ $selectedCountryId == $area->city->state->country_id ? 'selected' : '' }}
                                        hidden>
                                        {{ $area->city->state->country->country }}
                                    </option>

                                    @foreach($countries as $country)

                                    @if($country->id != $area->city->state->country_id)
                                    <option value="{{ $country->id }}"
                                        {{ $selectedCountryId == $country->id ? 'selected' : '' }}>
                                        {{ $country->country }}
                                    </option>
                                    @endif

                                    @endforeach

                                </select>
                            </div>

                        </form>

                        {{-- State Form --}}
                        <form action="{{ route('areas.edit', $area->id) }}" method="GET" id="stateForm">

                            <input type="hidden" name="country_id" value="{{ $selectedCountryId }}">

                            <div class="mb-3">
                                <label class="form-label">State</label>

                                <select name="state_id"
                                    class="form-select"
                                    onchange="this.form.submit()">

                                    @if(!$countryChanged)
                                    <!-- Current state (displayed but hidden from dropdown list) -->
                                    <option value="{{ $area->city->state_id }}"
                                        {{ $selectedStateId == $area->city->state_id ? 'selected' : '' }}
                                        hidden>
                                        {{ $area->city->state->state }}
                                    </option>
                                    @else
                                    <option value="" selected hidden>Select State</option>
                                    @endif

                                    @foreach($states as $state)

                                    @if(!$countryChanged && $state->id == $area->city->state_id)
                                    @continue
                                    @endif

                                    <option value="{{ $state->id }}"
                                        {{ $selectedStateId == $state->id ? 'selected' : '' }}>
                                        {{ $state->state }}
                                    </option>

                                    @endforeach

                                </select>
                            </div>

                        </form>

                        {{-- Update Form --}}
                        <form action="{{ route('areas.update', $area->id) }}" method="POST">

                            @csrf
                            @method('PUT')
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="country_id" value="{{ $selectedCountryId }}">
                            <input type="hidden" name="state_id" value="{{ $selectedStateId }}">

                            {{-- City --}}
                            <div class="mb-3">
                                <label class="form-label">City</label>

                                <select name="city_id" class="form-select @error('city_id') is-invalid @else @if($errors->any()) is-valid @endif @enderror">

                                    @if(!$countryChanged && !$stateChanged)
                                    <!-- Current city (displayed but hidden from dropdown list) -->
                                    <option value="{{ $area->city_id }}"
                                        {{ $selectedCityId == $area->city_id ? 'selected' : '' }}
                                        hidden>
                                        {{ $area->city->city }}
                                    </option>
                                    @else
                                    <option value="" selected hidden>Select City</option>
                                    @endif

                                    @foreach($cities as $city)

                                    @if(!$countryChanged && !$stateChanged && $city->id == $area->city_id)
                                    @continue
                                    @endif

                                    <option value="{{ $city->id }}"
                                        {{ $selectedCityId == $city->id ? 'selected' : '' }}>
                                        {{ $city->city }}
                                    </option>

                                    @endforeach

                                </select>

                                @error('city_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Area --}}
                            <div class="mb-3">
                                <label class="form-label">Area Name</label>

                                <input type="text"
                                    name="area"
                                    class="form-control @error('area') is-invalid @else @if($errors->any()) is-valid @endif @enderror"
                                    value="{{ old('area', $area->area) }}">

                                @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Pincode --}}
                            <div class="mb-3">
                                <label class="form-label">Pincode</label>

                                <input type="text"
                                    name="pincode"
                                    class="form-control @error('pincode') is-invalid @else @if($errors->any()) is-valid @endif @enderror"
                                    value="{{ old('pincode', $area->pincode) }}"
                                maxlength="6"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')">

                                @error('pincode')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="d-flex justify-content-start gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    Update Area
                                </button>
                                <a href="{{ route('areas.index') }}" class="btn btn-secondary">
                                    Back
                                </a>
                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>