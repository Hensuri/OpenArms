<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Arms - Registration</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&family=Montserrat:wght@300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/StyleRegist.css">
</head>

<body>
    <main class="registration-container">
        <div class="header">
            <img src="{{ asset('assets/images/Logo.svg') }}" alt="Open Arms Logo" class="logo-svg">
            <h1>OPEN ARMS</h1>
        </div>

        <h2>Registration</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('register.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required>
                @error('username')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Re-Enter Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="button-container">
                <button type="submit">Register</button>
            </div>
        </form>

        <div class="signin-link">
            Already have an account? <a href="/login">sign in</a>
        </div>
    </main>

</body>

</html>
