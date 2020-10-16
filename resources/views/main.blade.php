<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('public/assets/style/style.css') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Inconsolata&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
    <title>Minimø</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" 
        crossorigin="anonymous"></script>
</head>

<body>

    {{-- <section class="leaves">
        <div class="part">
            <div><img src="{{ asset('public/assets/images/leaves/leaves1.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves2.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves3.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves4.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves1.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves2.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves3.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves4.png') }}" alt=""></div>
        </div>
        <div class="part set2">
            <div><img src="{{ asset('public/assets/images/leaves/leaves1.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves2.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves3.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves4.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves1.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves2.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves3.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves4.png') }}" alt=""></div>
        </div>
        <div class="part set3">
            <div><img src="{{ asset('public/assets/images/leaves/leaves1.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves2.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves3.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves4.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves1.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves2.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves3.png') }}" alt=""></div>
            <div><img src="{{ asset('public/assets/images/leaves/leaves4.png') }}" alt=""></div>
        </div>
    </section> --}}

    <header>
        <div class="container-wide">
            <div class="header-content">
                <a href="{{route('homepage')}}" class="header-home">minimø</a>
                <nav class="header-menu">
                    <ul>
                        @foreach ($categories as $cat)
                            <li><a href="{{ $cat->id }}">{{ $cat->title }}</a></li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <section class="content">
        @yield('content')
    </section>

    <footer>
        <div class="container-wide">
            <div class="footer-content">
                <div class="footer-menu">
                    <ul>
                        <li><a href="#">Privacy</a></li>
                        <li><a href="#">Terms and conditions</a></li>
                    </ul>
                </div>
                <div class="footer-menu">
                    <ul>
                        <li>Follow</li>
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>