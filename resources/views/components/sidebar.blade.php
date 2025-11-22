<nav class="sidebar">
    <div class="sidebar-icon">
        <img src="{{ asset('assets/images/Logo_white.svg') }}" alt="Site Logo">
    </div>
    <a href="{{ route('Donation') }}" id="donations-link" class="sidebar-icon {{ request()->routeIs('Donation') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
        </svg>
    </a>

    <a href="{{ route('myDonationList') }}" id="create-link" class="sidebar-icon {{ request()->routeIs('myDonationList') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
        </svg>
    </a>
    
    <a href="{{ route('account.edit') }}" id="profile-link" class="sidebar-icon {{ request()->routeIs('account.edit') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
        </svg>
    </a>
    
    @can('admin')
        <a href="{{ route('adminDonation') }}" class="sidebar-icon {{ request()->routeIs('adminDonation') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M3 17v2h6v-2H3zM3 5v2h10V5H3zm10 16v-2h8v-2h-8v-2h-2v6h2zM7 9v2H3v2h4v2h2V9H7zm14 4v-2H11v2h10zm-6-4h2V7h4V5h-4V3h-2v6z" />
            </svg>
        </a>
    @endcan

    @auth
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="sidebar-icon-button" >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                </svg>
            </button>
        </form>
    @endauth
</nav>