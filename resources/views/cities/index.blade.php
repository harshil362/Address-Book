<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>City List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @include('layouts.navbar')

    <div class="container mt-5">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>City List</h2>

            <a href="{{ route('cities.create') }}" class="btn btn-primary">
                Add City
            </a>
        </div>

        <table class="table table-bordered table-striped">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>City</th>
                    <th>City Code</th>
                    <th>Status</th>
                    <th width="180">Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($cities as $city)

                <tr>

                    <td>{{ $city->id }}</td>

                    <td>{{ $city->state->country->country }}</td>

                    <td>{{ $city->state->state }}</td>

                    <td>{{ $city->city }}</td>

                    <td>{{ $city->city_code }}</td>

                    <td>
                        <form action="{{ route('cities.update', $city->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="country_id" value="{{ $city->state->country_id }}">
                            <input type="hidden" name="state_id" value="{{ $city->state_id }}">
                            <input type="hidden" name="city" value="{{ $city->city }}">
                            <input type="hidden" name="city_code" value="{{ $city->city_code }}">
                            <input type="hidden" name="status" value="{{ $city->status ? 0 : 1 }}">
                            <input type="hidden" name="action" value="status">

                            <div class="form-check form-switch">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    role="switch"
                                    onchange="this.form.submit()"
                                    {{ $city->status ? 'checked' : '' }}>
                            </div>
                        </form>
                    </td>

                    <td>

                        <a href="{{ route('cities.edit', $city->id) }}"
                            class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('cities.destroy', $city->id) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this city?')">
                                Delete
                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="7" class="text-center">
                        No City Found
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</body>

</html>