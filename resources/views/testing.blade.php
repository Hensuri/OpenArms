<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donations</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/StyleDonations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/OpenModal.css') }}">
</head>

<body>
    <nav class="sidebar">
        <div class="sidebar-icon">
            <img src="{{ asset('assets/images/Logo_white.svg') }}" alt="Site Logo">
        </div>
        <a href="/donations" id="donations-link" class="sidebar-icon active">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
            </svg>
        </a>

        <a href="/create-donation" id="create-link" class="sidebar-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
            </svg>
        </a>
       
        <a href="/profile" id="profile-link" class="sidebar-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
        </a>
    </nav>

    <div class="main-content">
    <header class="header">
        <h1>Donations</h1>
    </header>

        @foreach ($donationsByCategory as $category => $donations)
            <section>
                <div class="section-header">
                    <h2>{{ $categoryLabels[$category] ?? ucfirst($category) }}</h2>
                </div>
                <div class="donations-grid">
                    @foreach ($donations as $donation)
                        <div class="donation-card" wire:click="openDonation({{ $donation->id }})"
                            style="transition: transform 0.2s; cursor: pointer;"
                            onmouseover="this.style.transform='scale(1.03)'"
                            onmouseout="this.style.transform='scale(1)'">
                            <div class="donation-card-image"
                                style="background-image: url('{{ asset('storage/' . $donation->cover_image) ?? asset('images/default.jpg') }}'); background-size: cover; background-position: center;">
                                <div class="raised-tag green">
                                    IDR {{ number_format($donation->amount_raised, 0, ',', '.') }} Raised
                                </div>
                            </div>
                            <div class="donation-card-content">
                                <h3>{{ $donation->name }}</h3>
                                <p>{{ Str::limit($donation->description, 80) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
        
        @if ($showModal && $selectedDonation)
            <div class="modal-overlay" wire:click.self="closeModal">
                <div class="donation-modal">
                    <button class="close-btn" wire:click="closeModal">✕</button>

                    <div class="modal-header">
                        <img src="{{ asset('/storage/'. $selectedDonation->cover_image) ?? asset('images/default.jpg') }}" alt="{{ $selectedDonation->name }}">
                    </div>

                    <div class="modal-body">
                        <h2>{{ $selectedDonation->name }}</h2>

                        <div class="category-tag">
                            {{ ucfirst($selectedDonation->category ?? 'General') }}
                        </div>

                        <p>{{ $selectedDonation->description }}</p>

                        <div class="progress-info">
                            Raised over IDR {{ number_format($selectedDonation->amount_raised, 0, ',', '.') }}
                            / {{ number_format($selectedDonation->target_amount, 0, ',', '.') }}
                        </div>

                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $selectedDonation->raised_percentage }}%"></div>
                        </div>

                        <div class="progress-percent">{{ number_format($selectedDonation->raised_percentage, 0) }}% to goal</div>

                        <button class="donate-btn">Donate</button>
                    </div>
                </div>
            </div>
        @endif

</div>
    
    <script>
        const filterButton = document.querySelector('.filter-button');
        const filterDropdown = document.getElementById('filter-dropdown');
        const applyBtn = document.querySelector('.apply-btn');
        const byCategoryCheckbox = document.getElementById('by-category');
        const categorySelect = document.getElementById('category-select');

        filterButton.addEventListener('click', (event) => {
            event.stopPropagation();
            filterDropdown.classList.toggle('show');
        });

        applyBtn.addEventListener('click', () => {
            filterDropdown.classList.remove('show');
        });

        window.addEventListener('click', (event) => {
            if (!filterDropdown.contains(event.target) && !filterButton.contains(event.target)) {
                filterDropdown.classList.remove('show');
            }
        });

        filterDropdown.addEventListener('click', (event) => {
            event.stopPropagation();
        });

        byCategoryCheckbox.addEventListener('change', () => {
            if (byCategoryCheckbox.checked) {
                categorySelect.disabled = false;
            } else {
                categorySelect.disabled = true;
                categorySelect.selectedIndex = 0; 
            }
        });
    </script>
</body>

</html>