@auth
    <div>
        Hii {{ auth()->user()->username }}
    </div>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button href="index.html" class="dropdown-item" role="menuitem">
        Sign Out
        </button>
    </form>
@else
     
    <a href = "/login">Anda Belum Login</a>
@endauth