<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>City List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet"
        href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
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

        <div class="table-responsive">

            <table id="cities-table"
                class="table table-bordered table-striped table-hover align-middle">

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
                </tbody>

            </table>

        </div>

    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#cities-table').DataTable({

                processing: true,

                serverSide: true,

                ajax: "{{ route('cities.data') }}",

                columns: [

                    {
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'country',
                        name: 'state.country.country'
                    },

                    {
                        data: 'state',
                        name: 'state.state'
                    },

                    {
                        data: 'city',
                        name: 'city'
                    },

                    {
                        data: 'city_code',
                        name: 'city_code'
                    },

                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false,

                        render: function(data, type, row) {

                            return `
                <form action="/cities/${row.id}" method="POST">

                    <input type="hidden"
                           name="_token"
                           value="{{ csrf_token() }}">

                    <input type="hidden"
                           name="_method"
                           value="PUT">

                    <input type="hidden"
                           name="country_id"
                           value="${row.country_id}">

                    <input type="hidden"
                           name="state_id"
                           value="${row.state_id}">

                    <input type="hidden"
                           name="city"
                           value="${row.city}">

                    <input type="hidden"
                           name="city_code"
                           value="${row.city_code ?? ''}">

                    <input type="hidden"
                           name="status"
                           value="${row.status ? 0 : 1}">

                    <input type="hidden"
                           name="action"
                           value="status">

                    <div class="form-check form-switch">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            role="switch"
                            onchange="this.form.submit()"
                            ${row.status ? 'checked' : ''}>

                    </div>

                </form>
            `;
                        }
                    },

                    {
                        data: null,
                        name: 'action',
                        orderable: false,
                        searchable: false,

                        render: function(data, type, row) {

                            return `
                <a href="/cities/${row.id}/edit"
                   class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form action="/cities/${row.id}"
                      method="POST"
                      class="d-inline">

                    <input type="hidden"
                           name="_token"
                           value="{{ csrf_token() }}">

                    <input type="hidden"
                           name="_method"
                           value="DELETE">

                    <button type="submit"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this city?')">
                        Delete
                    </button>

                </form>
            `;
                        }
                    }

                ]
            });

        });
    </script>

</body>

</html>