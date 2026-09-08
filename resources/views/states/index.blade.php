<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>State List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet"
        href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
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

            <table id="states-table"
                class="table table-bordered table-striped table-hover align-middle">

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

            $('#states-table').DataTable({

                processing: true,

                serverSide: true,

                ajax: "{{ route('states.data') }}",

                columns: [

                    {
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'country',
                        name: 'country.country'
                    },

                    {
                        data: 'state',
                        name: 'state'
                    },

                    {
                        data: 'state_code',
                        name: 'state_code'
                    },

                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false,

                        render: function(data, type, row) {

                            return `
                                <form action="/states/${row.id}" method="POST">

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
                                           name="state"
                                           value="${row.state}">

                                    <input type="hidden"
                                           name="state_code"
                                           value="${row.state_code ?? ''}">

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
                                <a href="/states/${row.id}/edit"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="/states/${row.id}"
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
                                            onclick="return confirm('Are you sure you want to delete this state?')">
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