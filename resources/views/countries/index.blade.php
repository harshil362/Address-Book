<!DOCTYPE html>
<html>

<head>
    <title>Country List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
</head>

<body>
    @include('layouts.navbar')

    <div class="container mt-5">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Country List</h2>

            <a href="{{ route('countries.create') }}" class="btn btn-primary">
                Add Country
            </a>
        </div>

        <table id="countries-table" class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Country</th>
                    <th>Country Code</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            </tbody>
        </table>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>

    <script>
        

        $(document).ready(function() {
            $('#countries-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('countries.data') }}",

                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'country',
                        name: 'country'
                    },

                    {
                        data: 'country_code',
                        name: 'country_code'
                    },

                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false,

                        render: function(data, type, row) {

                        return `
                <form action="/countries/${row.id}" method="POST">

 

                    <input type="hidden"
                           name="_token"
                           value="{{ csrf_token() }}">

                    <input type="hidden"
                           name="_method"
                           value="PUT">

                    <input type="hidden"
                           name="country"
                           value="${row.country}">

                    <input type="hidden"
                           name="country_code"
                           value="${row.country_code}">

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
                <a href="/countries/${row.id}/edit"
                   class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form action="/countries/${row.id}"
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
                            onclick="return confirm('Are you sure you want to delete this country?')">
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