<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Donation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/CreateDonations.css') }}">
</head>

<body>

    <x-sidebar />

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

