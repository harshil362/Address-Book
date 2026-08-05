<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add State</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card shadow">

                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Add State</h4>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('states.store') }}" method="POST">

                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Country</label>

                                <select name="country_id" class="form-select @error('country_id') is-invalid @else @if($errors->any()) is-valid @endif @enderror">
                                    <option value="">Select Country</option>

                                    @foreach($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                        {{ $country->country }}
                                    </option>
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
                                    value="{{ old('state') }}"
                                    placeholder="Enter State Name">
                                @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">State Code</label>

                                <input type="text"
                                    name="state_code"
                                    class="form-control @error('state_code') is-invalid @else @if($errors->any()) is-valid @endif @enderror"
                                    value="{{ old('state_code') }}"
                                    placeholder="Enter State Code"
                                    maxlength="6"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                                @error('state_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-start gap-2 mt-3">
                                <button type="submit" class="btn btn-success">
                                    Save State
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