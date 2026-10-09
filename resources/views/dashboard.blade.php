<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

@include('layouts.navbar')

<div class="container mt-5">

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Dashboard</h4>
        </div>
        <div class="card-body">
            <h5>Welcome, {{ Auth::user()->name }}!</h5>
            <p class="text-muted">Manage your address book and master data from the links below.</p>
        </div>
    </div>

    <div class="row g-3">

        @if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasPermission('country.view'))
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Countries</h5>
                    <a href="{{ route('countries.index') }}" class="btn btn-outline-primary btn-sm">Open</a>
                </div>
            </div>
        </div>
        @endif

        @if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasPermission('state.view'))
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>States</h5>
                    <a href="{{ route('states.index') }}" class="btn btn-outline-primary btn-sm">Open</a>
                </div>
            </div>
        </div>
        @endif

        @if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasPermission('city.view'))
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Cities</h5>
                    <a href="{{ route('cities.index') }}" class="btn btn-outline-primary btn-sm">Open</a>
                </div>
            </div>
        </div>
        @endif

        @if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasPermission('area.view'))
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Areas</h5>
                    <a href="{{ route('areas.index') }}" class="btn btn-outline-primary btn-sm">Open</a>
                </div>
            </div>
        </div>
        @endif

        @if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasPermission('address_book.view'))
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Address Book</h5>
                    <a href="{{ route('addressbooks.index') }}" class="btn btn-outline-primary btn-sm">Open</a>
                </div>
            </div>
        </div>
        @endif

        @if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasPermission('role_assignment.view'))
        <div class="col-md-6">
            <div class="card shadow-sm border-success h-100">
                <div class="card-body text-center d-flex flex-column justify-content-between p-4">
                    <div>
                        <h5 class="text-success fw-bold"><i class="bi bi-shield-check me-2"></i>Role Permissions</h5>
                        <p class="text-muted small">Create roles with module-wise View, Create, Edit, Delete checkboxes and configure access.</p>
                    </div>
                    <div class="d-flex justify-content-center gap-2 mt-3">
                        <a href="{{ route('role-permissions.index') }}" class="btn btn-outline-success btn-sm px-3">View Roles</a>
                        <a href="{{ route('role-permissions.create') }}" class="btn btn-success btn-sm px-3">+ Add Role</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-primary h-100">
                <div class="card-body text-center d-flex flex-column justify-content-between p-4">
                    <div>
                        <h5 class="text-primary fw-bold"><i class="bi bi-people-fill me-2"></i>User & Role Management</h5>
                        <p class="text-muted small">Create new system user accounts and assign them roles to grant module permissions.</p>
                    </div>
                    <div class="d-flex justify-content-center gap-2 mt-3">
                        <a href="{{ route('role-assignments.index') }}" class="btn btn-outline-primary btn-sm px-3">View Users</a>
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm px-3">+ Add User</a>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
