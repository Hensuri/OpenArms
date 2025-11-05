
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Arms - Forgot Password</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&family=Montserrat:wght@300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/StyleForgotPWD.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/Logo_white.svg') }}">
</head>

<body>
    <main class="form-container">
        <div class="header">
            <img src="{{ asset('assets/images/Logo.svg') }}" alt="Open Arms Logo" class="logo-svg">
            <h1>OPEN ARMS</h1>
        </div>

        <h2>Forgot Password</h2>
        <form action="{{ route('password.send-code') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Email / Username</label>
                <input type="text" id="username" name="identifier">
            </div>

            <div class="button-container">
                <button type="submit">Send</button>
            </div>
        </form>

        <div class="bottom-link">
            Remember Your Account? <a href="{{ route('login') }}">Click Here</a>
        </div>
    </main>

</body>
</html>