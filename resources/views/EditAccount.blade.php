<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/StyleEditAccount.css') }}">
    <style>

    </style>
</head>

<body>
    <x-sidebar />

    <div class="main-content">
        <header class="header">
            <h1>Edit Account</h1>
        </header>
        <main class="content-area">
            <div class="profile-picture">
                @if (auth()->user()->profile_picture)
                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile picture" style="width:100px;height:100px;border-radius:50%;object-fit:cover;">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                @endif
            </div>
            @if (session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif

            <form class="edit-form" method="POST" action="{{ route('account.update') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username', auth()->user()->username) }}" required>
                    @error('username')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="profile_picture">Profile picture</label>
                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                    @error('profile_picture')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>
                    @error('current_password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button class="update-button" type="submit">Update Profile</button>
            </form>

        </main>
        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button class="logout-button">
                Log Out
            </button>
        </form>
    </div>

</body>

</html>