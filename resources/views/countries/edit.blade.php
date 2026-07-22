<!DOCTYPE html>
<html>
<head>
    <title>Edit Country</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Edit Country</h3>
        </div>

        <div class="card-body">

            <form action="{{ route('countries.update', $country->id) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Country Name</label>
                    <input 
                        type="text" 
                        name="country" 
                        class="form-control"
                        value="{{ $country->country }}"
                        placeholder="Enter country name">
                </div>

                <div class="mb-3">
                    <label class="form-label">Country Code</label>
                    <input 
                        type="text" 
                        name="country_code" 
                        class="form-control"
                        value="{{ $country->country_code }}"
                        placeholder="Enter country code">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>

                    <select name="status" class="form-select">
                        <option value="1" {{ $country->status == 1 ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="0" {{ $country->status == 0 ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">
                    Update
                </button>

                <a href="{{ route('countries.index') }}" class="btn btn-secondary">
                    Back
                </a>

            </form>

        </div>
    </div>

</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>