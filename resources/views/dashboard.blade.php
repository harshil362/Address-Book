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

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Countries</h5>
                    <a href="{{ route('countries.index') }}" class="btn btn-outline-primary btn-sm">Open</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>States</h5>
                    <a href="{{ route('states.index') }}" class="btn btn-outline-primary btn-sm">Open</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Cities</h5>
                    <a href="{{ route('cities.index') }}" class="btn btn-outline-primary btn-sm">Open</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Areas</h5>
                    <a href="{{ route('areas.index') }}" class="btn btn-outline-primary btn-sm">Open</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Address Book</h5>
                    <a href="{{ route('addressbooks.index') }}" class="btn btn-outline-primary btn-sm">Open</a>
                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
