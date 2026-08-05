<!DOCTYPE html>
<html>

<head>
    <title>Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">

            <div class="col-md-5">

                <div class="card shadow">

                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">Login</h4>
                    </div>

                    <div class="card-body p-4">

                        {{-- Success Message --}}
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        {{-- Login Error --}}
                        @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" novalidate>
                            @csrf

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    placeholder="Enter your email">

                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>

                                <div class="input-group">
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Enter your password">

                                    <button
                                        class="btn btn-outline-secondary"
                                        type="button"
                                        onclick="togglePassword()">
                                        👁
                                    </button>
                                </div>

                                @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- Remember Me --}}
                            <div class="mb-3 form-check">
                                <input
                                    type="checkbox"
                                    id="remember"
                                    name="remember"
                                    class="form-check-input"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    Remember Me
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Login
                            </button>

                        </form>

                        <div class="text-center mt-3">
                            Don't have an account?
                            <a href="{{ route('register') }}">Register here</a>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
    
    <!-- for the eye  -->
    <script>
        function togglePassword() {
            var x = document.getElementById("password");

            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>