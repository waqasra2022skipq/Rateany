<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" href="images/OIG2.x5WJPvCi944TyE_040uC.jpg" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
            integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
        <meta name="description" content="{{ $metaDescription ?? 'Find the top rated businesses and professionals' }}">
        <title>Rateany | {{ $pageTitle ?? 'Rate Anything and Anyone' }}</title>
        @vite(['resources/js/app.js'])
        @vite(['resources/sass/app.scss'])
        <script async src="https://www.google.com/recaptcha/api.js"></script>
    </head>

    <body class="mb-48">
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('images/logo.webp') }}" alt="Rateany Logo" class="logo rounded" width="80"
                        height="80">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact.show') }}">
                                <i class="fa-solid fa-comment"></i> Contact Us
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('allBusinesses') }}"><i
                                    class="user-link fa-solid fa-building"></i> Businesses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('allUsers') }}" class="text-white mx-3 user-link">
                                <i class="user-link fa-solid fa-user-md"></i> Professionals</a>
                        </li>
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-user-circle"></i> {{ auth()->user()->name }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ url('/profile/' . auth()->user()->id) }}">
                                            Manage Profile</a></li>
                                    <li><a class="dropdown-item" href="/businesses/manage">Manage Businesses</a></li>
                                    <li>
                                        <form method="POST" action="/auth/logout" class="py-2">
                                            @csrf
                                            <button type="submit" class="btn btn-link dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="/auth/login">
                                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Login
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
        @include('components.flash-message')

        <main class="mt-2 mb-5 pb-5">
            {{ $slot }}
        </main>

        <footer class="bg-dark text-white text-center py-3">
            <div class="container">
                <div class="d-flex justify-content-center align-items-center">
                    <a href="{{ route('allBusinesses') }}" class="text-white mx-3 user-link">Businesses</a>
                    <a href="{{ route('allUsers') }}" class="text-white mx-3 user-link">Professionals</a>
                    @if (auth()->check())
                        <a href="{{ route('profile.show', auth()->user()->id) }}"
                            class="user-link text-white mx-3">Profile</a>
                        <form action="/auth/logout" method="POST" class="mx-3">
                            @csrf
                            <button type="submit" class="user-link btn btn-link text-white p-0">Logout</button>
                        </form>
                    @endif
                </div>
                <p class="mb-0 mt-2">Copyright &copy; 2024, All Rights Reserved</p>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    </body>

</html>
