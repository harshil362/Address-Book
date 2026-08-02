<!DOCTYPE html>
<html>

<head>
    <title>Address Book List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    @include('layouts.navbar')
    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

                <h4>Address Book List</h4>

                <a href="{{ route('addressbooks.create') }}"
                    class="btn btn-light">
                    Add Address
                </a>

            </div>

            <div class="card-body">



                <table class="table table-bordered table-hover">

                    <thead class="table-dark">

                        <tr>

                            <th>ID</th>
                            <th>Contact Type</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Country</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Area</th>
                            <th>Status</th>
                            <th width="180">Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($addressbooks as $addressbook)

                        <tr>

                            <td>{{ $addressbook->id }}</td>

                            <td>{{ $addressbook->contact_type }}</td>

                            <td>{{ $addressbook->name }}</td>

                            <td>{{ $addressbook->mobile }}</td>

                            <td>{{ $addressbook->email }}</td>

                            <td>{{ $addressbook->country->country }}</td>

                            <td>{{ $addressbook->state->state }}</td>

                            <td>{{ $addressbook->city->city }}</td>

                            <td>{{ $addressbook->area->area }}</td>

                            <td>
                                <form action="{{ route('addressbooks.update', $addressbook->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="_status_toggle" value="1">
                                    <input type="hidden" name="status" value="{{ $addressbook->status ? 0 : 1 }}">
                                    <input type="hidden" name="action" value="status">

                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            role="switch"
                                            onchange="this.form.submit()"
                                            {{ $addressbook->status ? 'checked' : '' }}>
                                    </div>
                                </form>
                            </td>

                            <td>

                                <a href="{{ route('addressbooks.edit',$addressbook->id) }}"
                                    class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('addressbooks.destroy',$addressbook->id) }}"
                                    method="POST"
                                    style="display:inline;">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">

                                        Delete

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="11" class="text-center">
                                No Record Found
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