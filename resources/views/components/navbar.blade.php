@props(['admin' => false])

<nav class="navbar" style="background-color:#00ab41">
    <div class="container-fluid px-4">
        <a class="navbar-brand d-flex">
            <img src="{{ asset('assets/Logo.png') }}" alt="Description" class="logo">
            <h5 class="d-none d-sm-block my-auto" style="color:white;">Bhutan Development Bank Limited</h5>
        </a>
        @if ($admin)
            <form action="/logout" method="POST" class="d-flex mr-lg-5">
                @csrf
                <button class="btn" type="submit"
                    style="background-color:#fff;border:none;color:#00ab41;padding:7px 40px;border-radius:2px;">Logout</button>
            </form>
        @else
            <div class="d-flex  mr-lg-5">
                <img src="{{ asset('assets/profile.jpg') }}" alt="Description" width="50" height="50"
                    style="border-radius:100px;">
            </div>
        @endif
    </div>
</nav>
