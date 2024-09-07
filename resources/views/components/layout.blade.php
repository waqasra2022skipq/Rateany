<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <title>Rateany | Rate Anything and Anyone</title>
    @vite(['resources/js/app.js'])
    @vite(['resources/sass/app.scss'])
</head>

<body class="mb-48">
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('images/logo.png') }}" alt="Rateany Logo" class="logo" width="96">
            Rateany
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-user-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ url('/profile/' . auth()->user()->id) }}">Manage Profile</a></li>
                            <li><a class="dropdown-item" href="/businesses/manage">Manage Businesses</a></li>
                            <li><a class="dropdown-item" href="/reviews/manage">Manage Reviews</a></li>
                            <li>
                                <form method="POST" action="/auth/logout" class="px-3 py-2">
                                    @csrf
                                    <button type="submit" class="btn btn-link dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/register">
                            <i class="fa-solid fa-user-plus"></i> Register
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/login">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i> Login
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

    <footer class="fixed-bottom bg-dark text-white text-center">
        <p class="mb-0">Copyright &copy; 2024, All Rights Reserved</p>
        <a href="/reviews/create" class="btn btn-light position-absolute end-0 me-3">Write a Review</a>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <x-flash-message />
</body>

</html>
