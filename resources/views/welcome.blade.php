<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webacademy</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>
    <header>
        <div class="menu-wrapper">
            <a href="/" class="menu-left"><h3 class="logo">Webacademy<span class="dot"></span></h3></a>
            <ul class="menu-right">
                <li><a href="{{route('home')}}">Home</a></li>
                <li><a href="{{route('discussion.index')}}">Discussion</a></li>
                <li><a href="#">Pricing</a></li>
                <li><a href="{{ route('login') }}">Get Started.</a></li>
            </ul>
        </div>
    </header>
    
    <section id="hero">
        <div class="top-right-style"><img src="{{asset('images/white-round.svg') }}" alt=""></div>
        <div class="wrapper">
            <div class="hero-left">
                <h1>Kamu Belajar Lebih Gampang</h1>
                <p>Pelajaran berupa video interaktif dan evaluasi pembelajar yang dapat kamu akses kapan saja</p>
                <a href="" class="btn-primary">Let's Go</a>
            </div>
            <div class="hero-right">
                <img src="{{asset('images/undraw_bookshelves_xekd.svg')}}" alt="">
            </div>
        </div>
    </section>
    {{-- {{ dd($series) }} --}}
    <section id="course">
        <div class="wrapper">
            <div class="title">
                <h2>Daftar Pelajaran</h2>
            </div>
            <div class="cards">
                @foreach ($series as $item)                    
                    <div class="card">
                        <div class="card-header">
                            <img src="{{ asset($item->banner)}}" alt="">
                        </div>
                        <div class="card-body">
                            <div class="title"><h3>{{ Str::limit($item->title,40) }}</h3></div>
                            <p>+30 Videos</p>
                            <p>2 Quiz</p>
                        </div>
                    </div>
                @endforeach
                {{-- <div class="card">
                    <div class="card-header">
                        <img src="./resource/images/ant-rozetsky-HXOllTSwrpM-unsplash.jpg" alt="">
                    </div>
                    <div class="card-body">
                        <div class="title"><h3>Laravel Real World Project</h3></div>
                        <p>+30 Videos</p>
                        <p>+2 Quiz</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <img src="./resource/images/maxim-ilyahov-0aRycsfH57A-unsplash.jpg" alt="">
                    </div>
                    <div class="card-body">
                        <div class="title"><h3>Laravel Real World Project</h3></div>
                        <p>+30 Videos</p>
                        <p>2 Quiz</p>
                    </div>
                </div> --}}
            </div>
            <a href="{{route('client::series.list')}}" class="btn-secondary view-more">View More</a>
        </div>

        <div class="bottom-right-round"><img src="{{asset('images/purple-round.svg')}}" alt="purple"></div>
    </section>

    <section id="about">
        <div class="wrapper">
            <div class="title"><h2>Kenapa Memilih Kami</h2></div>
            <div class="content">
                <div class="about-left">
                    <span class="material-icons">video_library</span>
                    <h3>Video Interaktif</h3>
                    <p>Pembahasan dari tutor ahli dibidangnya dikemas dalam video yang tidak akan membosankan</p>
                </div>
                <div class="about-center">
                    <span class="material-icons">library_books</span>
                    <h3>Evaluasi Belajar</h3>
                    <p>Evaluasi pembelajaran akan dilakukan demi menunjang keahlian yang dimiliki peserta</p>
                </div>
                <div class="about-right">
                    <span class="material-icons">forum</span>
                    <h3>Forum Diskusi</h3>
                    <p>Komunitas yang solid dan siap membantu tiap permasalahan yang dihadapi peserta</p>
                </div>
            </div>
        </div>
    </section>

    <section id="pricing">
        <div class="wrapper">
            <div class="title"><h2>Bicara Harga</h2></div>
    
            <div class="pricing">
                @foreach ($plan as $item)                    
                    <div class="card">
                        <div>
                            <h3>{{$item->name}}</h3>
                            <h3 class="pricing-info">{{$item->month_of_subscription}} Bulan Akses</h3>
                        </div>
                        <div>
                            <h3 class="pricing-price">IDR {{$item->price/1000 . "K"}}</h3>
                        </div>
                        <a href="{{ route('client::subscription.invoice', $item->id) }}" class="btn-secondary">Get Now</a>
                    </div>
                @endforeach
                {{-- <div class="card">
                    <div>
                        <h3>Serius</h3>
                        <h3 class="pricing-info">3 Bulan Akses</h3>
                    </div>
                    <div>
                        <h3 class="pricing-price">IDR 600K</h3>
                    </div>
                    <a href="#" class="btn-secondary">Get Now</a>
                </div>
                <div class="card">
                    <div>
                        <h3>Professional</h3>
                        <h3 class="pricing-info">6 Bulan Akses</h3>
                    </div>
                    <div>
                        <h3 class="pricing-price">IDR 800K</h3>
                    </div>
                    <a href="#" class="btn-secondary">Get Now</a>
                </div> --}}
            </div>
        </div>
    </section>

    <footer>
        <div class="wrapper clearfix">
            <div class="footer-left">
                <a href="/"><h3>Webacademy <span class="dot-green"></span></h3></a>
            </div>

            <div class="footer-right">
                <h3>Social Account</h3>
                <a href="https://github.com/furqansdn"><ion-icon name="logo-github" class="social-icons"></ion-icon></a>
                <a href="https://www.instagram.com/furqansdn/"><ion-icon name="logo-instagram" class="social-icons"></ion-icon></a>
                <a href="https://twitter.com/furqansdn"><ion-icon name="logo-twitter" class="social-icons"></ion-icon></a>

            </div>
        </div>

        <div class="wrapper">
            <p class="copyright">Copyright @2020 Webacademy | By <span class="text-green">Furqan</span> With<span class="text-green"> &#10084;</span></p>
        </div>
    </footer>

    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

</body>
</html>