<!DOCTYPE html>
<html>

<head>
    <title>Area List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    @include('layouts.navbar')

    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Area List</h3>

                <a href="{{ route('areas.create') }}" class="btn btn-primary">
                    Add Area
                </a>
            </div>

            <div class="card-body">



                <table class="table table-bordered table-striped">

                    <thead class="table-dark">

                        <tr>
                            <th>ID</th>
                            <th>Country</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Area</th>
                            <th>Pincode</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($areas as $area)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $area->city->state->country->country }}</td>

                            <td>{{ $area->city->state->state }}</td>

                            <td>{{ $area->city->city }}</td>

                            <td>{{ $area->area }}</td>

                            <td>{{ $area->pincode }}</td>

                            <td>
                                <form action="{{ route('areas.update', $area->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="country_id" value="{{ $area->city->state->country_id }}">
                                    <input type="hidden" name="state_id" value="{{ $area->city->state_id }}">
                                    <input type="hidden" name="city_id" value="{{ $area->city_id }}">
                                    <input type="hidden" name="area" value="{{ $area->area }}">
                                    <input type="hidden" name="pincode" value="{{ $area->pincode }}">
                                    <input type="hidden" name="status" value="{{ $area->status ? 0 : 1 }}">
                                    <input type="hidden" name="action" value="status">

                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            role="switch"
                                            onchange="this.form.submit()"
                                            {{ $area->status ? 'checked' : '' }}>
                                    </div>
                                </form>
                            </td>
                            <td>

                                <a href="{{ route('areas.edit', $area->id) }}"
                                    class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('areas.destroy', $area->id) }}"
                                    method="POST"
                                    style="display:inline-block;">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this area?')">
                                        Delete
                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="8" class="text-center">
                                No Area Found.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>

</html>