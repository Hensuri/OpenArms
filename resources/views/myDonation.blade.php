<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Donations</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/myDonation.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/Logo_white.svg') }}">
</head>

<body>
    <x-sidebar />
    <div class="main-content">
        <header class="header">
            <h1>Open Donation</h1>
        </header>

        <main class="content-wrapper">
            <section class="your-donations-section">
                <h2 class="section-title">Your Donations</h2>
                <div class="donations-grid">
                    @forelse ($donations as $donation)
                        <div class="donation-card">
                            <div class="donation-card-image" 
                                style="background-image: url({{ asset('storage/' . $donation->cover_image) }})">
                                <div class="raised-tag {{ $donation->status === 'approved' ? 'green' : ($donation->status === 'rejected' ? 'red' : 'gray') }}">
                                    {{ ucfirst($donation->status) }}
                                </div>
                            </div>
                            <div class="donation-card-content">
                                <h3>{{ $donation->name }}</h3>
                                <p>{{ Str::limit($donation->description, 80) }}</p>
                                <button class="edit-btn">Edit</button>
                            </div>
                        </div>
                    @empty
                        <p>You haven't created any donations yet.</p>
                    @endforelse
                </div>
            </section>

            <hr class="divider">

            <section class="create-donation-section">
                <h2 class="section-title">Create New Donation</h2>
                <a class="create-button" href="{{route('createDonation')}}">Create</a>
            </section>
        </main>
    </div>
</body>

</html>