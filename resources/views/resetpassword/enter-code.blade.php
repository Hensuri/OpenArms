<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Arms - Registration</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/StyleVerification.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/Logo_white.svg') }}">
</head>

<body>
    <main class="form-container">
        
        <div class="header">
            <img src="{{ asset('assets/images/Logo.svg') }}" alt="Open Arms Logo" class="logo-svg">
            <h1>OPEN ARMS</h1>
        </div>

        <h2>Verify Your Code</h2>
        <div class="text">
            <p>A Verification Code has been send to</p>
            <span class="email">{{ session('identifier') }}</span>
            <a href="{{ route('password.request') }}">Change<a>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('password.verify-code') }}" method="POST">
            @csrf
            <input type="hidden" name="identifier" value="{{ session('identifier') }}">
            <div class="form-group">
                <label for="verification-code">Verification Code</label>
                <input type="text" id="verification-code" name="verification-code">
            </div>

            <div class="button-container">
                <button type="submit">Send</button>
            </div>
        </form>


        <form action="{{ route('password.send-code') }}" method="POST"class="link-button">
            @csrf
            <input type="hidden" name="identifier" value="{{ session('identifier') }}">
            <button type="submit" id="sendCodeBtn">Send Code</button>
        </form>
    </main>
</body>

</html>

<script>
window.addEventListener('DOMContentLoaded', () => {
    const button = document.getElementById('sendCodeBtn');
    const cooldownTime = 10; // detik
    startCooldown(cooldownTime);

    function startCooldown(seconds) {
        let remaining = seconds;
        const originalText = button.textContent;
        button.disabled = true;
        button.textContent = `Wait ${remaining}s`;

        const timer = setInterval(() => {
            remaining--;
            button.textContent = `Wait ${remaining}s`;

            if (remaining <= 0) {
                clearInterval(timer);
                button.disabled = false;
                button.textContent = originalText;
            }
        }, 1000);
    }
});
</script>
