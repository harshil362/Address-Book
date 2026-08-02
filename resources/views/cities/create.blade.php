<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add City</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body >

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add City</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('cities.create') }}" method="GET">

                        <div class="mb-3">
                            <label class="form-label">Country</label>

                            <select name="country_id" class="form-select" onchange="this.form.submit()">

                                <option value="">Select Country</option>

                                @foreach($countries as $country)

                                    <option value="{{ $country->id }}"
                                        {{ old('country_id', request('country_id')) == $country->id ? 'selected' : '' }}>

                                        {{ $country->country }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </form>


                    <form action="{{ route('cities.store') }}" method="POST">

                        @csrf

                        <input type="hidden"
                               name="country_id"
                               value="{{ old('country_id', request('country_id')) }}">

                         <div class="mb-3">

                             <label class="form-label">State</label>

                             <select name="state_id" class="form-select @error('state_id') is-invalid @else @if($errors->any()) is-valid @endif @enderror">

                                 <option value="">Select State</option>

                                 @foreach($states as $state)

                                     <option value="{{ $state->id }}"
                                         {{ old('state_id') == $state->id ? 'selected' : '' }}>

                                         {{ $state->state }}

                                     </option>

                                 @endforeach

                             </select>

                             @error('state_id')
                                 <div class="invalid-feedback">{{ $message }}</div>
                             @enderror

                         </div>

                         <div class="mb-3">

                             <label class="form-label">City Name</label>

                             <input type="text"
                                    name="city"
                                    class="form-control @error('city') is-invalid @else @if($errors->any()) is-valid @endif @enderror"
                                    value="{{ old('city') }}">

                             @error('city')
                                 <div class="invalid-feedback">{{ $message }}</div>
                             @enderror

                         </div>

                         <div class="mb-3">

                             <label class="form-label">City Code</label>

                             <input type="text"
                                    name="city_code"
                                    class="form-control @error('city_code') is-invalid @else @if($errors->any()) is-valid @endif @enderror"
                                    value="{{ old('city_code') }}">

                             @error('city_code')
                                 <div class="invalid-feedback">{{ $message }}</div>
                             @enderror

                         </div>

                         <!-- <div class="mb-3">
                             <label class="form-label">Status</label>
                             <select name="status" class="form-select @error('status') is-invalid @else @if($errors->any()) is-valid @endif @enderror">
                                 <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                 <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                             </select>
                             @error('status')
                                 <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                         </div> -->
                         
                         <div class="d-flex justify-content-start gap-2 mt-3">
                             <button type="submit" class="btn btn-primary">
                                 Save City
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>