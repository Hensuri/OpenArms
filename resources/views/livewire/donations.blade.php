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

                    <button class="donate-btn" wire:click="openDonateForm">Donate</button>
                </div>
            </div>
        </div>
    @endif

    @if ($showDonateForm)
        <div class="modal-overlay" wire:click.self="closeDonateForm">
            <div class="donation-form-modal">
                <button class="close-btn" wire:click="closeDonateForm">✕</button>

                <h2>Donate to {{ $selectedDonation->name }}</h2>

                <form wire:submit.prevent="submitDonation" class="donation-form">
                    <label for="donationAmount">Donation Amount (IDR):</label>
                    <input type="number" id="donationAmount" wire:model="donationAmount" placeholder="Enter amount">

                    @error('donationAmount') 
                        <span class="error">{{ $message }}</span> 
                    @enderror

                    <div class="checkbox">
                        <input type="checkbox" id="isAnonymous" wire:model="isAnonymous">
                        <label for="isAnonymous">Donate anonymously</label>
                    </div>

                    <button type="submit" class="submit-btn">Confirm Donation</button>
                </form>
            </div>
        </div>
    @endif

</div>