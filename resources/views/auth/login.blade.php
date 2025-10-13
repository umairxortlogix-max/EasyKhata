<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login - Easy Khata</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body,
    html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #e0e5ec;
    }

    .main-container {
      display: flex;
      height: 100vh;
    }

    /* Left Side - Branding */
    .left-side {
      flex: 1;
      background: #e0e5ec;
      color: #333;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 50px;
      text-align: center;
      box-shadow: inset 10px 10px 20px #bec3c9,
        inset -10px -10px 20px #ffffff;
      border-radius: 0 40px 40px 0;
    }

    .left-side h1 {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 15px;
    }

    .left-side p {
      font-size: 1.1rem;
      opacity: 0.8;
      max-width: 400px;
    }

    /* Right Side - Login Form */
    .right-side {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #e0e5ec;
    }

    .login-card {
      background: #e0e5ec;
      border-radius: 25px;
      box-shadow: 10px 10px 20px #bec3c9,
        -10px -10px 20px #ffffff;
      padding: 40px;
      width: 400px;
      transition: all 0.3s ease;
    }

    .login-card:hover {
      box-shadow: 6px 6px 12px #bec3c9,
        -6px -6px 12px #ffffff;
    }

    .login-card h4 {
      text-align: center;
      font-weight: 700;
      margin-bottom: 25px;
      color: #222;
      text-shadow: 1px 1px 2px #fff;
    }

    .form-label {
      font-weight: 500;
      color: #333;
    }

    .form-control {
      border: none;
      border-radius: 12px;
      padding: 12px;
      background: #e0e5ec;
      box-shadow: inset 6px 6px 10px #bec3c9,
        inset -6px -6px 10px #ffffff;
      transition: 0.3s ease;
    }

    .form-control:focus {
      outline: none;
      box-shadow: inset 3px 3px 6px #bec3c9,
        inset -3px -3px 6px #ffffff;
    }

    .btn-login {
      background: #e0e5ec;
      border: none;
      color: #333;
      font-weight: 600;
      border-radius: 12px;
      width: 100%;
      padding: 12px;
      margin-top: 10px;
      box-shadow: 6px 6px 12px #bec3c9,
        -6px -6px 12px #ffffff;
      transition: all 0.2s ease-in-out;
    }

    .btn-login:hover {
      box-shadow: inset 6px 6px 12px #bec3c9,
        inset -6px -6px 12px #ffffff;
      color: #2575fc;
    }

    .form-check-input {
      box-shadow: inset 3px 3px 5px #bec3c9,
        inset -3px -3px 5px #ffffff;
      border: none;
      background: #e0e5ec;
    }

    .extra-links {
      margin-top: 15px;
      text-align: center;
    }

    .extra-links a {
      color: #2575fc;
      font-weight: 500;
      text-decoration: none;
    }

    .extra-links a:hover {
      text-decoration: underline;
    }

    /* Make it responsive */
    @media (max-width: 768px) {
      .main-container {
        flex-direction: column;
      }

      .left-side {
        border-radius: 0;
        padding: 40px 20px;
      }

      .login-card {
        width: 90%;
      }
    }
  </style>

</head>

<body>

  <div class="main-container">
    <!-- Left Branding Section -->
    <div class="left-side">
      <h1>Welcome Back!</h1>
      <p>Login to <b>Easy Khata</b> and manage your accounts effortlessly with our modern dashboard.</p>
    </div>

    <!-- Right Login Section -->
    <div class="right-side">
      <div class="login-card">
        <h4>Sign In</h4>

        @if(session('status'))
          <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
          @csrf

          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="text" name="email" class="form-control" value="{{ old('email') }}" required
              autofocus>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" class="form-control" required>
          </div>

          <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
            <label for="remember_me" class="form-check-label">Remember me</label>
          </div>

          <button type="submit" class="btn btn-login">Login</button>

          <div class="extra-links">
            @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}">Forgot Password?</a>
            @endif
          </div>
        </form>
      </div>
    </div>
  </div>

</body>

</html>