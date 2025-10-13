<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Easy Khata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-success text-white">
                    <h4>Create Account - Easy Khata</h4>
                </div>
                <div class="card-body">

                    {{-- Show validation errors --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Registration form --}}
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input id="name" type="text" name="name" class="form-control"
                                   value="{{ old('name') }}" required autofocus>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" type="email" name="email" class="form-control"
                                   value="{{ old('email') }}" required>
                        </div>

                        <!-- Mobile Number -->
                        <div class="mb-3">
                            <label for="number" class="form-label">Mobile Number</label>
                            <input id="number" type="text" name="number" class="form-control"
                                   value="{{ old('number') }}" required>
                        </div>

                        <!-- Expiry Date -->
                        <div class="mb-3">
                            <label for="expiry_date" class="form-label">Expiry Date</label>
                            <input id="expiry_date" type="date" name="expiry_date" class="form-control"
                                   value="{{ old('expiry_date') }}" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" name="password" class="form-control" required>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                   class="form-control" required>
                        </div>

                        <!-- Submit button -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Register</button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center">
                    Already have an account? <a href="{{ route('login') }}">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
