<!DOCTYPE html>
<html>

<head>
    <title>Country List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Country List</h2>

        <a href="{{ route('countries.create') }}" class="btn btn-primary">
            Add Country
        </a>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Country</th>
                <th>Country Code</th>
                <th>Status</th>
                <th width="180">Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($countries as $country)
            <tr>
                <td>{{ $country->id }}</td>
                <td>{{ $country->country }}</td>
                <td>{{ $country->country_code }}</td>

                <td>
                    @if($country->status == 1)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </td>

                <td>
                    <a href="{{ route('countries.edit', $country->id) }}"
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form action="{{ route('countries.destroy', $country->id) }}"
                          method="POST"
                          class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this country?')">
                            Delete
                        </button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

</div>

</body>

</html>