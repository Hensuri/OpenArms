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

                <div class="modal-header" wire:click="closeDonateForm">
                    <img src="{{ asset('/storage/'. $selectedDonation->cover_image) ?? asset('images/default.jpg') }}" alt="{{ $selectedDonation->name }}">
                </div>

                <div class="modal-body" wire:click="closeDonateForm">
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

                    <div class="transaction-history">
                        <h3>Recent Donations</h3>

                        @if ($transactions->isEmpty())
                            <p>No donations yet.</p>
                        @else
                            <ul>
                                @foreach ($transactions as $trx)
                                    <li class="transaction-item">
                                        <strong>
                                            {{ $trx->is_anon ? 'Orang Baik' : ($trx->user->username ?? 'Orang Baik') }}
                                        </strong>
                                        donated 
                                        <span>IDR {{ number_format($trx->gross_amount, 0, ',', '.') }}</span>
                                        <small>on {{ $trx->created_at->format('d M Y, H:i') }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="donation-form" wire:click.stop>
                        @unless($showDonateForm)
                            <button class="donate-btn" wire:click="openDonateForm">Donate</button>
                        @endunless

                        @if ($showDonateForm)
                            <form wire:submit.prevent="submitDonation" class="donation-input">
                                <label for="donationAmount">Donation Amount (IDR):</label>
                                <input type="number" id="donationAmount" wire:model="donationAmount" placeholder="Enter amount">
                                
                                @auth
                                    <div class="checkbox">
                                        <input type="checkbox" id="isAnonymous" wire:model="isAnonymous">
                                        <label for="isAnonymous">Donate anonymously</label>
                                    </div>
                                @endauth
                                

                                <button type="submit" class="donate-btn">Confirm Donation</button>
                            </form>
                        @endif
                    </div>
                </div>
                
            </div>
        </div>
    @endif
</div>