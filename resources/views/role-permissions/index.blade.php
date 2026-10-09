<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles & Module Permissions</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6fa;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            color: #1e293b;
        }

        .card-custom {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            background: #ffffff;
            overflow: hidden;
        }

        .badge-role {
            font-size: 0.85rem;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
        }

        .btn-create-role {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            font-weight: 600;
            padding: 8px 18px;
            border-radius: 10px;
            border: none;
            transition: all 0.2s;
        }

        .btn-create-role:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            color: white;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            transform: translateY(-1px);
        }
    </style>
</head>

<body>

@include('layouts.navbar')

<div class="container py-4" style="max-width: 1200px;">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Roles & Permissions</li>
                </ol>
            </nav>
            <h3 class="fw-bold mb-1 text-slate-800">
                <i class="bi bi-shield-check text-primary me-2"></i>Roles & Module Permissions
            </h3>
            <p class="text-muted mb-0">Manage roles with module-wise View, Create, Edit, Delete permissions.</p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('role-assignments.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-people me-1"></i>Role Assignments
            </a>
            <a href="{{ route('role-permissions.create') }}" class="btn btn-create-role">
                <i class="bi bi-shield-plus me-1"></i>Add New Role
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card card-custom">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold text-secondary">
                <i class="bi bi-list-check me-2"></i>Configured Roles
            </h5>
            <span class="badge bg-light text-dark border px-3 py-2">{{ $roles->count() }} Total Roles</span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" width="70">#</th>
                            <th>Role Name</th>
                            <th>Description</th>
                            <th>Assigned Users</th>
                            <th>Module Permissions</th>
                            <th class="text-end pe-4" width="220">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td class="ps-4 text-muted">{{ $role->id }}</td>
                                <td>
                                    <span class="badge {{ $role->name === 'Super Admin' ? 'bg-danger' : ($role->name === 'Admin' ? 'bg-primary' : 'bg-secondary') }} badge-role">
                                        <i class="bi bi-shield me-1"></i>{{ $role->name }}
                                    </span>
                                </td>
                                <td class="text-muted">
                                    {{ $role->description ?? 'No description provided' }}
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1">
                                        <i class="bi bi-people me-1"></i>{{ $role->users_count }} Users
                                    </span>
                                </td>
                                <td>
                                    @if($role->name === 'Super Admin')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle py-1 px-2">
                                            <i class="bi bi-shield-fill-check me-1"></i>All Permissions (Full Access)
                                        </span>
                                    @else
                                        <span class="text-primary fw-semibold">
                                            <i class="bi bi-check2-circle me-1"></i>{{ $role->permissions_count }} of 20 permissions
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        @if($role->name === 'Super Admin')
                                            <span class="badge bg-light text-muted border py-2 px-3">
                                                <i class="bi bi-lock-fill me-1"></i>Static Admin
                                            </span>
                                        @else
                                            <a href="{{ route('role-permissions.edit', $role->id) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Edit Role & Permissions">
                                                <i class="bi bi-pencil-square me-1"></i>Edit
                                            </a>

                                            @if(!in_array($role->name, ['Super Admin', 'Admin', 'User']))
                                                <form action="{{ route('role-permissions.destroy', $role->id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Delete role \'{{ $role->name }}\'?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Role">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-shield-slash fs-2 d-block mb-2"></i>
                                    No roles found. Click <strong>Add New Role</strong> to create one.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
