<!DOCTYPE html>
<html>

<head>
    <title>Register</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <style>

    </style>
    <div class="container mt-5">
        <div class="row justify-content-center">

            <div class="col-md-5">

                <div class="card shadow">

                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">Register</h4>
                    </div>

                    <div class="card-body p-4">

                        {{-- Error Message --}}
                        @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- Full Name --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}"
                                    placeholder="Enter your name">

                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

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
                                        placeholder="Minimum 8 characters">

                                    <button class="btn btn-outline-secondary"
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

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">
                                    Confirm Password
                                </label>

                                <div class="input-group">
                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Re-enter your password">

                                    <button
                                        class="btn btn-outline-secondary"
                                        type="button"
                                        onclick="toggleConfirmPassword()">
                                        👁
                                    </button>
                                </div>

                                @error('password')
                                @if($message == 'Password confirmation does not match.')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @endif
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Register
                            </button>

                        </form>

                        <div class="text-center mt-3">
                            Already have an account?
                            <a href="{{ route('login') }}">Login here</a>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- for the password eye -->
    <script>
        function togglePassword() {
            var x = document.getElementById("password");

            if (x.type == "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function toggleConfirmPassword() {
            var x = document.getElementById("password_confirmation");

            if (x.type == "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>


    <!--Bootstrap JS-- >
        <script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" >

</body>

</html>