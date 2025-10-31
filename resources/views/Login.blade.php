<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Arms - Sign In</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&family=Montserrat:wght@300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/StyleLogin.css') }}">
</head>

<body>
    <main class="login-container">
        <div class="header">
            <img src="{{ asset('assets/images/Logo.svg') }}" alt="Open Arms Logo" class="logo-svg">
            <h1>OPEN ARMS</h1>
        </div>
        <h2>Sign In</h2>
        <form action="{{ route('login.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
                @if ($errors->any())
                    <div class="error-message">The provided credentials do not match our records.</div>
                @endif
            </div>

            <div class="button-container">
                <button type="submit">Login</button>
                <div class="forgot-password">
                    Forgot your password? <a href="/forgot-password">click here</a>
                </div>
            </div>
        </form>

        <div class="signup">
            Don’t have an account? <a href="/register">click here</a>
        </div>
    </main>

</body>

</html>