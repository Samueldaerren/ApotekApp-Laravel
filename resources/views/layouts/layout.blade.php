<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apoteker App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing_page') }}">Apotek App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            @if (Auth::check())
                @if (Auth::user()->role == 'admin')
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link{{ Route::is('landing_page') ? ' active' : '' }}" aria-current="page"
                                    href="{{ route('landing_page') }}">Dashboard</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link {{ Route::is('medicine.show') || Route::is('medicine.create') ? ' active' : '' }} dropdown-toggle"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if (Route::is('medicine.create'))
                                        Add Medicines
                                    @elseif (Route::is('medicine.show'))
                                        Medicines
                                    @else
                                        Medicines
                                    @endif
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('medicine.show') }}">Medicines</a></li>
                                    <li><a class="dropdown-item" href="{{ route('medicine.create') }}">Add Medicine</a>
                                    </li>
                                </ul>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{ route('purchase.index') }}" class="nav-link">Pembelian</a>
                            </li> --}}
                            <li class="nav-item dropdown">
                                <a class="nav-link {{ Route::is('user.create') || Route::is('user.index') ? ' active' : '' }} dropdown-toggle"
                                    aria-current="page" href="#" data-bs-toggle="dropdown" role="button"
                                    aria-expanded="false">
                                    @if (Route::is('user.create'))
                                        Users create
                                    @elseif (Route::is('user.index'))
                                        Users
                                    @else
                                        Users
                                    @endif
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href=" {{ route('user.index') }}">Users</a></li>
                                    <li><a class="dropdown-item" href=" {{ route('user.create') }}">Create User</a></li>
                                    <li><a class="dropdown-item" href=" {{ route('pembelian.admin') }}">Data pembelian</a></li>
                                </ul>
                @endif
                @if (Auth::check())
                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                        </li>
                    @endif
                @endif
                </li>
                </ul>
            @endif

            @if (Auth::check())
                @if (Auth::user()->role == 'cashier')
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link{{ Route::is('landing_page') ? ' active' : '' }}" aria-current="page"
                                    href="{{ route('landing_page') }}">Dashboard</a>
                            </li>
                            <li class="nav-item" 9>
                                <a href="{{ route('pembelian.index') }}" class="nav-link">Pembelian</a>
                            </li>
                @endif
                @if (Auth::check())
                    @if (Auth::user()->role == 'cashier')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                        </li>
                    @endif
                @endif
                </li>
                </ul>
            @endif



        </div>
        </div>
    </nav>

    <div class="container mt-5">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

    @stack('script')
</body>

</html>