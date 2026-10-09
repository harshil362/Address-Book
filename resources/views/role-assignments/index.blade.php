<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User & Role Assignments</title>
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
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
        }
        .btn-create-user {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            font-weight: 600;
            padding: 8px 18px;
            border-radius: 10px;
            border: none;
            transition: all 0.2s;
        }
        .btn-create-user:hover {
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

    <!-- Top Navigation & Action -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users & Role Assignments</li>
                </ol>
            </nav>
            <h3 class="fw-bold mb-1 text-slate-800">
                <i class="bi bi-people-fill text-primary me-2"></i>User & Role Assignments
            </h3>
            <p class="text-muted mb-0">Assign User or Admin roles to users to grant module-wise permissions.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('role-permissions.create') }}" class="btn btn-outline-primary">
                <i class="bi bi-shield-plus me-1"></i>Add New Role
            </a>
            <a href="{{ route('role-permissions.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-shield-check me-1"></i>Role Permissions
            </a>
            <a href="{{ route('users.create') }}" class="btn btn-create-user">
                <i class="bi bi-person-plus-fill me-1"></i>Add New User
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

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Quick Role Assignment Card -->
    <div class="card card-custom mb-4">
        <div class="card-header bg-white py-3 px-4 border-bottom">
            <h6 class="mb-0 fw-bold text-primary">
                <i class="bi bi-arrow-left-right me-2"></i>Quick Role Assignment for Existing Users
            </h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('role-assignments.store') }}" method="POST">
                @csrf

                <div class="row g-3 align-items-end">
                    <!-- User Selection -->
                    <div class="col-md-5">
                        <label class="form-label fw-semibold text-slate-700">
                            Select Existing User <span class="text-danger">*</span>
                        </label>
                        <select name="user_id" class="form-select" required>
                            <option value="">-- Choose User --</option>
                            @foreach($users as $user)
                                @if(!$user->isSuperAdmin())
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                        @if($user->roles->count() > 0)
                                            — [Role: {{ $user->roles->pluck('name')->join(', ') }}]
                                        @else
                                            — [No Role]
                                        @endif
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Role Selection -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-slate-700">
                            Assign Role <span class="text-danger">*</span>
                        </label>
                        <select name="role_id" class="form-select" required>
                            <option value="">-- Choose Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Action Button -->
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-lg me-1"></i>Update User Role
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users & Current Role Assignments Table -->
    <div class="card card-custom">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold text-secondary">
                <i class="bi bi-people me-2"></i>System Users & Assigned Roles
            </h5>
            <span class="badge bg-light text-dark border px-3 py-2">{{ $users->count() }} Total Users</span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" width="70">#</th>
                            <th>User Name</th>
                            <th>Email Address</th>
                            <th>Assigned Role</th>
                            <th>Effective Permissions</th>
                            <th class="text-end pe-4" width="220">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="ps-4 text-muted">{{ $user->id }}</td>
                                <td class="fw-semibold">
                                    <i class="bi bi-person-circle text-secondary me-2"></i>{{ $user->name }}
                                </td>
                                <td class="text-muted">{{ $user->email }}</td>
                                <td>
                                    @forelse($user->roles as $role)
                                        <span class="badge {{ $role->name === 'Super Admin' ? 'bg-danger' : ($role->name === 'Admin' ? 'bg-primary' : 'bg-secondary') }} badge-role">
                                            <i class="bi bi-shield me-1"></i>{{ $role->name }}
                                        </span>
                                    @empty
                                        <span class="badge bg-light text-muted border">No Role Assigned</span>
                                    @endforelse
                                </td>
                                <td>
                                    @if($user->isSuperAdmin())
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                            <i class="bi bi-shield-fill-check me-1"></i>All Permissions (Super Admin)
                                        </span>
                                    @else
                                        @php
                                            $totalPerms = $user->allPermissions()->count();
                                        @endphp
                                        @if($totalPerms > 0)
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fw-semibold">
                                                <i class="bi bi-check2-circle me-1"></i>{{ $totalPerms }} permissions
                                            </span>
                                        @else
                                            <span class="badge bg-light text-muted border px-2 py-1">0 permissions</span>
                                        @endif
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    @if($user->isSuperAdmin())
                                        <span class="badge bg-light text-muted border py-2 px-3">
                                            <i class="bi bi-shield-lock me-1"></i>Static Admin
                                        </span>
                                    @else
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary" title="Edit User & Role">
                                                <i class="bi bi-pencil-square me-1"></i>Edit
                                            </a>

                                            <form action="{{ route('role-assignments.destroy', $user->id) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Delete user {{ $user->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete User">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-person-x fs-2 d-block mb-2"></i>
                                    No users found in the system. Click <strong>Add New User</strong> to create one.
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