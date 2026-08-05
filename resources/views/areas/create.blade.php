<!DOCTYPE html>
<html>

<head>
    <title>Add Area</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card shadow">

                    <div class="card-header bg-primary text-white">
                        <h4>Add Area</h4>
                    </div>

                    <div class="card-body">

                        @php
                        $selectedCountryId = old('country_id', request('country_id'));
                        $selectedStateId = old('state_id', request('state_id'));
                        @endphp

                        {{-- Country Form --}}
                        <form action="{{ route('areas.create') }}" method="GET">

                            <div class="mb-3">

                                <label>Country</label>

                                <select name="country_id"
                                    class="form-control"
                                    onchange="this.form.submit()">

                                    <option value="">Select Country</option>

                                    @foreach($countries as $country)

                                    <option value="{{ $country->id }}"
                                        {{ $selectedCountryId == $country->id ? 'selected' : '' }}>

                                        {{ $country->country }}

                                    </option>

                                    @endforeach

                                </select>

                            </div>

                        </form>

                        {{-- State Form --}}
                        <form action="{{ route('areas.create') }}" method="GET">

                            <input type="hidden"
                                name="country_id"
                                value="{{ $selectedCountryId }}">

                            <div class="mb-3">

                                <label>State</label>

                                <select name="state_id"
                                    class="form-control"
                                    onchange="this.form.submit()">

                                    <option value="">Select State</option>

                                    @foreach($states as $state)

                                    <option value="{{ $state->id }}"
                                        {{ $selectedStateId == $state->id ? 'selected' : '' }}>

                                        {{ $state->state }}

                                    </option>

                                    @endforeach

                                </select>

                            </div>

                        </form>

                        {{-- Store Form --}}
                        <form action="{{ route('areas.store') }}" method="POST">

                            @csrf

                            <input type="hidden"
                                name="country_id"
                                value="{{ $selectedCountryId }}">

                            <input type="hidden"
                                name="state_id"
                                value="{{ $selectedStateId }}">

                            {{-- City --}}
                            <div class="mb-3">

                                <label>City</label>

                                <select name="city_id" class="form-control @error('city_id') is-invalid @else @if($errors->any()) is-valid @endif @enderror">

                                    <option value="">Select City</option>

                                    @foreach($cities as $city)

                                    <option value="{{ $city->id }}"
                                        {{ old('city_id') == $city->id ? 'selected' : '' }}>

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

                                <label>Area</label>

                                <input type="text"
                                    name="area"
                                    class="form-control @error('area') is-invalid @else @if($errors->any()) is-valid @endif @enderror"
                                    value="{{ old('area') }}">

                                @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>

                            {{-- Pincode --}}
                            <div class="mb-3">

                                <label>Pincode</label>

                                <input type="text"
                                    name="pincode"
                                    class="form-control @error('pincode') is-invalid @else @if($errors->any()) is-valid @endif @enderror"
                                    value="{{ old('pincode') }}"

                                    maxlength="6"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                                    
                                @error('pincode')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="d-flex justify-content-start gap-2 mt-3">
                                <button type="submit" class="btn btn-success">
                                    Save
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

</body>

</html>