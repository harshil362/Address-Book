<!DOCTYPE html>
<html>

<head>
    <title>Address Book List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet"
        href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
</head>

<body class="bg-light">

    @include('layouts.navbar')

    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

                <h4>Address Book List</h4>

                @if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasPermission('address_book.create'))
                <a href="{{ route('addressbooks.create') }}"
                    class="btn btn-light">
                    Add Address
                </a>
                @endif

            </div>

            <div class="card-body">

                <table id="addressbooks-table"
                    class="table table-bordered table-hover">

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
                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>


    <script>
        const canEdit = @json(auth()->user()->hasRole('Super Admin') || auth()->user()->hasPermission('address_book.edit'));
        const canDelete = @json(auth()->user()->hasRole('Super Admin') || auth()->user()->hasPermission('address_book.delete'));

        $(document).ready(function() {

            $('#addressbooks-table').DataTable({

                processing: true,

                serverSide: true,

                ajax: "{{ route('addressbooks.data') }}",

                columns: [

                    {
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'contact_type',
                        name: 'contact_type'
                    },

                    {
                        data: 'name',
                        name: 'name'
                    },

                    {
                        data: 'mobile',
                        name: 'mobile'
                    },

                    {
                        data: 'email',
                        name: 'email'
                    },

                    {
                        data: 'country',
                        name: 'country.country'
                    },

                    {
                        data: 'state',
                        name: 'state.state'
                    },

                    {
                        data: 'city',
                        name: 'city.city'
                    },

                    {
                        data: 'area',
                        name: 'area.area'
                    },

                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false,

                        render: function(data, type, row) {
                            if (!canEdit) {
                                return row.status
                                    ? '<span class="badge bg-success">Active</span>'
                                    : '<span class="badge bg-secondary">Inactive</span>';
                            }

                            return `
            <form action="/addressbooks/${row.id}" method="POST">

                <input type="hidden"
                       name="_token"
                       value="{{ csrf_token() }}">

                <input type="hidden"
                       name="_method"
                       value="PUT">

                <input type="hidden"
                       name="contact_type"
                       value="${row.contact_type ?? ''}">

                <input type="hidden"
                       name="name"
                       value="${row.name ?? ''}">

                <input type="hidden"
                       name="mobile_no"
                       value="${row.mobile ?? ''}">

                <input type="hidden"
                       name="alternate_mobile"
                       value="${row.alternate_mobile ?? ''}">

                <input type="hidden"
                       name="email"
                       value="${row.email ?? ''}">

                <input type="hidden"
                       name="country_id"
                       value="${row.country_id ?? ''}">

                <input type="hidden"
                       name="state_id"
                       value="${row.state_id ?? ''}">

                <input type="hidden"
                       name="city_id"
                       value="${row.city_id ?? ''}">

                <input type="hidden"
                       name="area_id"
                       value="${row.area_id ?? ''}">

                <input type="hidden"
                       name="address_line_1"
                       value="${row.address1 ?? ''}">

                <input type="hidden"
                       name="address_line_2"
                       value="${row.address2 ?? ''}">

                <input type="hidden"
                       name="landmark"
                       value="${row.landmark ?? ''}">

                <input type="hidden"
                       name="pincode"
                       value="${row.pincode ?? ''}">

                <input type="hidden"
                       name="is_default_address"
                       value="${row.is_default ?? 0}">

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
                            let actions = '';

                            if (canEdit) {
                                actions += `
                                    <a href="/addressbooks/${row.id}/edit"
                                       class="btn btn-warning btn-sm me-1">
                                        Edit
                                    </a>
                                `;
                            }

                            if (canDelete) {
                                actions += `
                                    <form action="/addressbooks/${row.id}"
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
                                                onclick="return confirm('Are you sure you want to delete this address book?')">
                                            Delete
                                        </button>

                                    </form>
                                `;
                            }

                            return actions || '<span class="text-muted small">-</span>';
                        }
                    }
                ]

            });

        });
    </script>

</body>

</html>