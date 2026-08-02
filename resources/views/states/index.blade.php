<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>State List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @include('layouts.navbar')

    <div class="container mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>State List</h2>

            <a href="{{ route('states.create') }}" class="btn btn-primary">
                Add State
            </a>
        </div>



        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>State Code</th>
                        <th>Status</th>
                        <th width="170">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($states as $state)

                    <tr>

                        <td>{{ $state->id }}</td>

                        <td>{{ $state->country->country }}</td>

                        <td>{{ $state->state }}</td>

                        <td>{{ $state->state_code }}</td>

                        <!-- status -->
                        <td>
                            <form action="{{ route('states.update', $state->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="country_id" value="{{ $state->country_id }}">
                                <input type="hidden" name="state" value="{{ $state->state }}">
                                <input type="hidden" name="state_code" value="{{ $state->state_code }}">
                                <input type="hidden" name="status" value="{{ $state->status ? 0 : 1 }}">
                                <input type="hidden" name="action" value="status">

                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        onchange="this.form.submit()"
                                        {{ $state->status ? 'checked' : '' }}>
                                </div>
                            </form>
                        </td>

                        <td>
                            <a href="{{ route('states.edit', $state->id) }}"
                                class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('states.destroy', $state->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this state?')">
                                    Delete
                                </button>

                            </form>
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No states found.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>