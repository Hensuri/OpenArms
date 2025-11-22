<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Arms - Registration</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/StyleEnterPWD.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/Logo_white.svg') }}">
</head>

<body>
    <main class="form-container">
        
        <div class="header">
            <img src="{{ asset('assets/images/Logo.svg') }}" alt="Open Arms Logo" class="logo-svg">
            <h1>OPEN ARMS</h1>
        </div>

        <h2>New Password</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('password.reset') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <label for="password">Enter Your New Password </label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Re-Enter Your New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror

            <div class="button-container">
                <button type="submit">Send</button>
            </div>
        </form>
    </main>
</body>

</html>
