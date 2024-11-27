@props(['admin' => false])

<nav class="navbar overflow-hidden p-1"
    @if (false) style="background: linear-gradient(75deg, #c7c7c7 0%, #818181 20%)" @else style="background: linear-gradient(75deg, #4fc208 0%, #00ab41 20%)" @endif>
    @if (false)
        <img src="{{ asset('assets/waves_admin.png') }}" class="position-absolute bottom-0 end-0 z-n1 waves">
    @else
        <img src="{{ asset('assets/waves.png') }}" class="position-absolute bottom-0 end-0 z-n1 waves">
    @endif
    <div class="container-fluid px-md-4">
        <a class="navbar-brand d-flex" href="/">
            <img src="{{ asset('assets/Logo.png') }}" alt="Bhutan Development Bank Limited" class="logo me-2">
            <h4 class="d-none d-sm-block my-auto" style="color:white;">
                @if ($admin)
                    ADMIN PANEL
                @else
                    @php
                        $type = request()->query('type');
                    @endphp
                    BDBL e-Recruitment @if ($type == 'internal')
                        Internal
                    @endif
                @endif
            </h4>
        </a>
        @if ($admin)
            <form action="/logout" method="POST" class="d-flex mr-lg-5">
                @csrf
                <button class="btn" type="submit"
                    style="background-color:#fff;border:none;color:#636363;z-index: 1;">LOG OUT</button>
            </form>
        @else
            <a href="/login" style="z-index: 1;">
                <img src="{{ asset('assets/manager.png') }}" height="30">
            </a>
        @endif
    </div>
</nav>
