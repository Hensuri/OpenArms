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
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
    </script>
</head>

<body>
    <x-sidebar />

    {{ $slot }}
    
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

        <script type="text/javascript">
            document.addEventListener('livewire:init', () => {
                Livewire.on('openSnap', data => {
                    console.log('Snap token diterima:', data.snap_token);
                    const donationId = data.donation_id; 
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result){
                            console.log('Success', result);
                            Livewire.dispatch('refreshDonation', { id: donationId });
                        },
                        onPending: function(result){
                            console.log('Pending', result);
                            Livewire.dispatch('refreshDonation', { id: donationId });
                        },
                        onError: function(result){
                            console.error('Error', result);
                            Livewire.dispatch('refreshDonation', { id: donationId });
                        },
                        onClose: function(){
                            console.log('Popup closed');
                            Livewire.dispatch('refreshDonation', { id: donationId });
                        }
                    });
                });
            });
        </script>

</body>

</html>