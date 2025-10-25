<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Donation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/createDonations.css">
</head>

<body>

    <nav class="sidebar">
        <div class="sidebar-icon">
            <img src="Images/Logo2.png" alt="Site Logo">
        </div>

        <div class="sidebar-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
            </svg>
        </div>

        <div class="sidebar-icon active">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
            </svg>
        </div>

        <div class="sidebar-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
        </div>
    </nav>

    <div class="main-content">
        <header class="header">
            <h1>Open Donation</h1>
        </header>
        <main class="content-area">
            <div class="donation-form-container">
                <div class="form-header">
                    <img src="/assets/images/Logo_white.svg" alt="Site Logo">
                    <h2>Donation Registration</h2>
                </div>
                <div class="form-content-wrapper">
                    <form action="{{ route('addDonation') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="donation-name">Donation Name</label>
                            <input type="text" name="donation-name" id="donation-name" placeholder="Your Donation Name">
                        </div>
                        <div class="form-group">
                            <label for="donation-target">Donation Target</label>
                            <div class="target-input-wrapper">
                                <input type="text" name="donation-target" id="donation-target" placeholder="ex. 1.000.000.000">
                                <span class="currency-label">IDR</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="donation-description">Donation Description</label>
                            <textarea id="donation-description" name="donation-description" placeholder="Write a neat description..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="category">Choose Category</label>
                            <select id="category" name="category">
                                <option value="" disabled selected>Choose a category</option>
                                <option value="humanity">Humanity</option>
                                <option value="environment">Environment</option>
                                <option value="education">Education</option>
                                <option value="health">Health</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Cover Image</label>
                            <p class="image-upload-note">We recommend an image that's at least 800px wide and 320px tall
                            </p>
                            <input type="file" name="cover_image" accept="image/*">
                        </div>
                        <div class="form-actions">
                            <a class="cancel-button" href="{{route('myDonationList')}}">Cancel</a>
                            <button type="submit" class="submit-button">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

</body>

</html>

