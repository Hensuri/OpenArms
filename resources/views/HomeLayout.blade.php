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

                window.snap.pay(data.snap_token, {
                    onSuccess: function(result){
                        console.log('Success', result);
                    },
                    onPending: function(result){
                        console.log('Pending', result);
                    },
                    onError: function(result){
                        console.error('Error', result);
                    },
                    onClose: function(){
                        console.log('Popup closed');
                    }
                });
            });
        });
    </script>

</body>

</html>