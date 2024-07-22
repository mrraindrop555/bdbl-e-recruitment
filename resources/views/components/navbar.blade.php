@props(['admin' => false])

<nav class="navbar overflow-hidden p-1" style="background: linear-gradient(75deg, #4fc208 0%, #00ab41 20%)">
    <img src="{{ asset('assets/waves.png') }}" class="position-absolute bottom-0 end-0 z-n1 waves">
    <div class="container-fluid px-md-4">
        <a class="navbar-brand d-flex">
            <img src="{{ asset('assets/Logo.png') }}" alt="Bhutan Development Bank Limited" class="logo me-2">
            <h4 class="d-none d-sm-block my-auto" style="color:white;">BDBL e-Recruitment</h4>
        </a>
        @if ($admin)
            <form action="/logout" method="POST" class="d-flex mr-lg-5">
                @csrf
                <button class="btn" type="submit"
                    style="background-color:#fff;border:none;color:#00ab41;padding:7px 40px;border-radius:2px; z-index: 1;">Logout</button>
            </form>
        @else
            <a href="/login" style="z-index: 1;">
                <img src="{{ asset('assets/manager.png') }}" height="30">
            </a>
        @endif
    </div>
</nav>
