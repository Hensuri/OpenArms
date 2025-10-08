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
    <link rel="stylesheet" href="css/StyleForgotPWD.css">
</head>

<body>
    <main class="form-container">
        <div class="header">
            <img src="storage/Images/Logo.svg" alt="Open Arms Logo" class="logo-svg">
            <h1>OPEN ARMS</h1>
        </div>

        <h2>Forgot Password</h2>
        <form action="#" method="POST">
            <div class="form-group">
                <label for="username">Email / Username</label>
                <input type="text" id="username" name="username">
            </div>

            <div class="button-container">
                <button type="submit" href="/verify">Send</button>
            </div>
        </form>

        <div class="bottom-link">
            Remember Your Account? <a href="/login">Click Here</a>
        </div>
    </main>

</body>

</html>