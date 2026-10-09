<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User - Role & Permissions</title>

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

        .main-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        }

        .module-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.2s;
            height: 100%;
        }

        .module-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .module-header {
            padding: 12px 16px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            border-top-left-radius: 11px;
            border-top-right-radius: 11px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .module-body {
            padding: 14px 16px;
        }

        .action-check-pill {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #ffffff;
            cursor: pointer;
            transition: all 0.15s ease;
            user-select: none;
            margin-bottom: 0;
        }

        .action-check-pill:hover {
            background: #f8fafc;
            border-color: #3b82f6;
        }

        .action-check-pill input[type="checkbox"] {
            margin-right: 8px;
            cursor: pointer;
            width: 17px;
            height: 17px;
        }

        .btn-create-user {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 10px;
            border: none;
        }

        .btn-create-user:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            color: white;
        }
    </style>
</head>

<body>

@include('layouts.navbar')

<div class="container py-4" style="max-width: 1100px;">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('role-assignments.index') }}" class="text-decoration-none">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add New User</li>
                </ol>
            </nav>
            <h3 class="fw-bold mb-1 text-slate-800">
                <i class="bi bi-person-plus text-primary me-2"></i>Create New User
            </h3>
            <p class="text-muted mb-0">Create an account and assign a role and module-wise permissions.</p>
        </div>
        <div>
            <a href="{{ route('role-assignments.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back to Users
            </a>
        </div>
    </div>

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

    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <div class="main-card p-4 p-md-5 mb-4">

            <!-- User Information -->
            <div class="mb-4 pb-4 border-bottom">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="bi bi-person-badge text-primary me-2"></i>1. Account Details
                </h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. John Doe" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="e.g. john@example.com" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Re-type password" required>
                    </div>
                </div>
            </div>

            <!-- Role Assignment -->
            <div class="mb-4 pb-4 border-bottom">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="bi bi-shield-check text-primary me-2"></i>2. Role Assignment
                </h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Assign Role <span class="text-danger">*</span></label>
                        <select name="role_id" class="form-select" required>
                            <option value="">-- Select Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">User inherits all permissions configured on this role.</small>
                    </div>
                </div>
            </div>

            <!-- Section 3: Module Permissions -->
            <div class="mb-4 pb-2">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="bi bi-grid-3x3-gap text-primary me-2"></i>3. Module Permissions (Direct Permissions)
                        </h5>
                        <small class="text-muted">Optionally assign direct module permissions specifically to this user.</small>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-primary" id="selectAllBtn">
                            <i class="bi bi-check-all me-1"></i>Select All
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAllBtn">
                            <i class="bi bi-x-lg me-1"></i>Deselect All
                        </button>
                    </div>
                </div>

                <div class="row g-3">
                    @foreach($modules as $module)
                        <div class="col-md-6">
                            <div class="module-card">
                                <div class="module-header">
                                    <span class="fw-bold text-slate-800">
                                        <i class="bi bi-folder2-open text-primary me-2"></i>{{ $module->name }}
                                    </span>
                                    <button type="button" class="btn btn-sm btn-link p-0 text-decoration-none module-select-all"
                                            data-target="mod_{{ $module->id }}">
                                        Toggle All
                                    </button>
                                </div>
                                <div class="module-body">
                                    <div class="row g-2">
                                        @foreach($module->permissions as $permission)
                                            <div class="col-6">
                                                <label class="action-check-pill w-100" for="perm_{{ $permission->id }}">
                                                    <input type="checkbox"
                                                           name="permissions[]"
                                                           value="{{ $permission->id }}"
                                                           id="perm_{{ $permission->id }}"
                                                           class="perm-checkbox mod_{{ $module->id }}"
                                                           {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="fw-semibold text-capitalize">
                                                        {{ ucfirst($permission->action ?: last(explode('-', $permission->name))) }}
                                                    </span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Submit -->
            <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                <a href="{{ route('role-assignments.index') }}" class="btn btn-light px-4">Cancel</a>
                <button type="submit" class="btn btn-create-user px-4">
                    <i class="bi bi-person-check me-1"></i>Create User
                </button>
            </div>

        </div>
    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('selectAllBtn').addEventListener('click', function() {
        document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = true);
    });

    document.getElementById('deselectAllBtn').addEventListener('click', function() {
        document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = false);
    });

    document.querySelectorAll('.module-select-all').forEach(btn => {
        btn.addEventListener('click', function() {
            const targetClass = this.getAttribute('data-target');
            const checkboxes = document.querySelectorAll('.' + targetClass);
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            checkboxes.forEach(cb => cb.checked = !allChecked);
        });
    });
</script>
</body>
</html>
