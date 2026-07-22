<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Country</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-5">

                <div class="card shadow">

                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center mb-0">Add Country</h3>
                    </div>

                    <div class="card-body">

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('countries.store') }}" method="POST">

                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Country Name</label>
                                <input
                                    type="text"
                                    name="country"
                                    class="form-control"
                                    placeholder="Enter Country Name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Country Code</label>
                                <input
                                    type="text"
                                    name="country_code"
                                    class="form-control"
                                    placeholder="Enter Country Code">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>