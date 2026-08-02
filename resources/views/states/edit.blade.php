<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit State</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card shadow">

                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Edit State</h4>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('states.update', $state->id) }}" method="POST">

                            @csrf
                            @method('PUT')
                            <input type="hidden" name="action" value="update">

                            <div class="mb-3">
                                <label class="form-label">Country</label>

                                <select name="country_id" class="form-select @error('country_id') is-invalid @else @if($errors->any()) is-valid @endif @enderror">

                                    <!-- Current country (displayed but hidden from dropdown list) -->
                                    <option value="{{ $state->country_id }}"
                                        {{ old('country_id', $state->country_id) == $state->country_id ? 'selected' : '' }}
                                        hidden>
                                        {{ $state->country->country }}
                                    </option>

                                    @foreach($countries as $country)

                                    @if($country->id != $state->country_id)
                                    <option value="{{ $country->id }}"
                                        {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                        {{ $country->country }}
                                    </option>
                                    @endif

                                    @endforeach

                                </select>
                                @error('country_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="mb-3">
                                <label class="form-label">State Name</label>

                                <input type="text"
                                    name="state"
                                    class="form-control @error('state') is-invalid @else @if($errors->any()) is-valid @endif @enderror"
                                    value="{{ old('state', $state->state) }}">
                                @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">State Code</label>

                                <input type="text"
                                    name="state_code"
                                    class="form-control @error('state_code') is-invalid @else @if($errors->any()) is-valid @endif @enderror"
                                    value="{{ old('state_code', $state->state_code) }}">
                                @error('state_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="d-flex justify-content-start gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    Update State
                                </button>
                                <a href="{{ route('states.index') }}" class="btn btn-secondary">
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