<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit City</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card shadow">

                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Edit City</h4>
                    </div>

                    <div class="card-body">

                        @php
                        $selectedCountryId = old('country_id', request('country_id', $city->state->country_id));
                        $countryChanged = $selectedCountryId != $city->state->country_id;
                        $selectedStateId = $countryChanged ? old('state_id') : old('state_id', $city->state_id);
                        @endphp

                        <!-- Country Selection -->
                        <form action="{{ route('cities.edit', $city->id) }}" method="GET">

                            <div class="mb-3">
                                <label class="form-label">Country</label>

                                <select name="country_id"
                                    class="form-select"
                                    onchange="this.form.submit()">

                                    <!-- Current country (displayed but hidden from dropdown list) -->
                                    <option value="{{ $city->state->country_id }}"
                                        {{ $selectedCountryId == $city->state->country_id ? 'selected' : '' }}
                                        hidden>
                                        {{ $city->state->country->country }}
                                    </option>

                                    @foreach($countries as $country)

                                    @if($country->id != $city->state->country_id)
                                    <option value="{{ $country->id }}"
                                        {{ $selectedCountryId == $country->id ? 'selected' : '' }}>
                                        {{ $country->country }}
                                    </option>
                                    @endif

                                    @endforeach

                                </select>

                            </div>

                        </form>

                        <!-- Update Form -->
                        <form action="{{ route('cities.update', $city->id) }}" method="POST">

                            @csrf
                            @method('PUT')
                            <input type="hidden" name="action" value="update">
                            
                            <input type="hidden"
                                name="country_id"
                                value="{{ $selectedCountryId }}">

                            <!-- State -->
                            <div class="mb-3">
                                <label class="form-label">State</label>

                                <select name="state_id" class="form-select @error('state_id') is-invalid @else @if($errors->any()) is-valid @endif @enderror">

                                    @if(!$countryChanged)
                                    <!-- Current state (displayed but hidden from dropdown list) -->
                                    <option value="{{ $city->state_id }}"
                                        {{ $selectedStateId == $city->state_id ? 'selected' : '' }}
                                        hidden>
                                        {{ $city->state->state }}
                                    </option>
                                    @else
                                    <option value="" selected hidden>Select State</option>
                                    @endif

                                    @foreach($states as $state)

                                    @if(!$countryChanged && $state->id == $city->state_id)
                                    @continue
                                    @endif

                                    <option value="{{ $state->id }}"
                                        {{ $selectedStateId == $state->id ? 'selected' : '' }}>
                                        {{ $state->state }}
                                    </option>

                                    @endforeach

                                </select>

                                @error('state_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- City -->
                            <div class="mb-3">
                                <label class="form-label">City Name</label>

                                <input type="text"
                                    name="city"
                                    class="form-control @error('city') is-invalid @else @if($errors->any()) is-valid @endif @enderror"
                                    value="{{ old('city', $city->city) }}">

                                @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- City Code -->
                            <div class="mb-3">
                                <label class="form-label">City Code</label>

                                <input type="text"
                                    name="city_code"
                                    class="form-control @error('city_code') is-invalid @else @if($errors->any()) is-valid @endif @enderror"
                                    value="{{ old('city_code', $city->city_code) }}">

                                @error('city_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="d-flex justify-content-start gap-2 mt-3">

                                <button type="submit" class="btn btn-primary">
                                    Update City
                                </button>

                                <a href="{{ route('cities.index') }}" class="btn btn-secondary">
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