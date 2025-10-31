<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Donation;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\MidtransController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Donations extends Component
{
    public $selectedDonation = null;
    public $showModal = false;
    public $showDonateForm = false;
    public $donationAmount;
    public $isAnonymous = false;
    public $selectedDonationId = null;

    public function getDonationsByCategoryProperty()
    {
        return Donation::where('status', 'approved')
        ->get()
        ->groupBy('category');
    }

    public function openDonation($id)
    {
        $this->selectedDonation = Donation::find($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function openDonateForm()
    {
        if ($this->selectedDonation) {
            $this->selectedDonationId = $this->selectedDonation->id;
            $this->showDonateForm = true;
        }
    }

    public function closeDonateForm()
    {
        $this->showDonateForm = false;
    }

    public function submitDonation()
    {
        $this->validate([
            'donationAmount' => 'required|numeric|min:1000',
        ]);

        $data = [
            'donation_id' => $this->selectedDonationId,
            'amount' => $this->donationAmount,
            'isAnonymous' => $this->isAnonymous,
            'donator' => Auth::id(),
        ];

        $request = Request::create(route('midtrans.create'), 'POST', $data);

        $midtransController = new MidtransController;
        $response = $midtransController->create($request);

        log::info($response); 

        if (!empty($response['snap_token'])) {
            $this->dispatch('openSnap', snap_token: $response['snap_token']);
        }
        
        $this->reset(['donationAmount', 'isAnonymous', 'showDonateForm']);
        session()->flash('success', 'Donation submitted successfully!');
    }

    public function render()
    {
        $categoryLabels = [
            'Health' => 'Health and Well Being',
            'Humanity' => 'Victims of Natural Disasters',
            'Environment' => 'Protecting Our Planet',
            'Education' => 'Education for All',
        ];

        return view('livewire.donations', [
            'donationsByCategory' => $this->donationsByCategory,
            'categoryLabels' => $categoryLabels,
        ])->layout('HomeLayout');
    }
}
