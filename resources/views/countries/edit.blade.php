<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Country</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card shadow">

                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Edit Country</h4>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('countries.update', $country->id) }}" method="POST">

                            @csrf
                            @method('PUT')
<input type="hidden" name="action" value="update">
                             <div class="mb-3">
                                <label class="form-label">Country Name</label>

                                <input type="text"
                                    name="country"
                                    class="form-control @error('country') is-invalid @else @if($errors->any()) is-valid @endif @enderror"
                                    value="{{ old('country', $country->country) }}">
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                             </div>

                             <div class="mb-3">
                                <label class="form-label">Country Code</label>

                                <input type="text"
                                    name="country_code"
                                    class="form-control @error('country_code') is-invalid @else @if($errors->any()) is-valid @endif @enderror"
                                    value="{{ old('country_code', $country->country_code) }}">
                                @error('country_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                             </div>

                          

                             <div class="d-flex justify-content-start gap-2 mt-3">
                                 <button type="submit" class="btn btn-primary">
                                     Update Country
                                 </button>
                                 <a href="{{ route('countries.index') }}" class="btn btn-secondary">
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