<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Font Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    {{-- CDN Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Feather Icons --}}
    <script src="https://unpkg.com/feather-icons"></script>
    {{-- Sweet Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- AOS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <title>WGG: Beyond</title>
    <style>
        html{
            scroll-behavior: smooth;
        }
        
        ::-webkit-scrollbar {
            width: 7px;
        }

        /* Track (the background) */
        ::-webkit-scrollbar-track {
            background: black; /* Matches your design */
        }

        /* Handle (the moving part) */
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #32215a, #8a79b3, white); /* Gradient effect */
            border-radius: 10px; /* Rounded edges */
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #4a2c72, #a497c5, white);
        }
        .nav-link:hover, .hamburger-menu:hover{
            color: #f6a868;
        }

        .nav-link::after{
            content: "";
            display: block;
            padding-bottom: .3rem;
            border-bottom: .1rem solid #f6a868;
            transform: scaleX(0);
            transition: .3s linear;
        }

        .nav-link:hover::after{
            transform: scaleX(.6);
        }

        .navbar-extra{
            display: none;
            cursor: pointer;
        }

        footer{
            text-align: center;
            padding: 1rem 0 1.8rem;
            margin-top: 3rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        footer .credit {
            font-size: .8rem;
        }
        footer .credit a{
            color: #f6a868;
            font-weight: 700;
        }

        @media (max-width:768px){
            html{
                font-size: 75%;
            }

            .navbar-extra{
                display: inline-block;
            }

            /* Untuk membuat navbar hilang digantikan hamburger navigation */
            .navbar-nav{
                position: absolute;
                top: 100%;
                right: -100%;
                background-color: rgba(5, 5, 5, 0.3);
                width: 50%;
                height: 100vh;
                display: flex;
                border-radius: 20px;
                flex-direction: column;
                justify-content: center;
                transition: .3s;
                padding-right: 0;
            }

            /* Untuk ketika dicetek hamburgernya baru muncul navigasinya dibantu dengan javascript */
            .navbar-nav.active{
                right: 0;
            }

            /* Style navbar yang muncul */
            .nav-link{
                text-align: center;
                font-size: 2rem;
            }

            .nav-link:hover::after{
                transform: scaleX(.1);
            }
        }

        .navbar-blur {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="w-full overflow-x-hidden h-auto text-white font-['Poppins']" style="background: linear-gradient(180deg, rgba(16,6,33,1) 0%, rgba(20,27,52,1) 50%, rgba(24,64,59,1) 100%);">
    <nav class="flex justify-between items-center mb-4 py-3 px-[7%] border-b border-gray-800 z-[999] fixed top-0 right-0 left-0 bg-black/10 backdrop-blur-xl">
        <a href="/" class="font-bold uppercase text-lg italic">Beyond</a>
        <ul class="navbar-nav flex gap-10 lg:gap-6 text-lg text-center">
            @auth
            <li>
                <span class="font-bold ">
                    Welcome {{ ucfirst(auth()->user()->name) }}
                </span>
            </li>
            <li>
                <a href="{{ route('cards.manage') }}" class="nav-link text-center"
                    ><i class="fa-solid fa-gear"></i>
                    Manage Cards</a
                >
            </li>
            <li>
                <form action="/logout" method="POST" class="inline nav-link">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </li>
            
            @else
            <li>
                <a href="/register" class="nav-link text-center"
                    >Register</a
                >
            </li>
            <li>
                <a href="/login" class="nav-link text-center"
                    >Login</a
                >
            </li>
            @endauth
        </ul>
        <div class="navbar-extra z-[999]">
            <a id="hamburger-menu"><i data-feather="menu"></i></a>
        </div>
    </nav>
    <main>
        {{ $slot }}
    </main>

    <footer class="border-t border-gray-800 bg-black/50 backdrop-blur-xl">
        <div class="credit">
            <p>Created by <a href="https://github.com/clarenceevanw/">clarenceevanw</a>. | &copy; 2025</p>
        </div>
    </footer>

    <script>
        feather.replace();
    </script>
    <script>
        const navbarNav = document.querySelector(".navbar-nav");
        const hamburgerMenu = document.querySelector("#hamburger-menu");

        hamburgerMenu.addEventListener('click', ()=> {
            navbarNav.classList.toggle('active');
        });

        document.addEventListener('click', (e) =>{
            if(!hamburgerMenu.contains(e.target) && !navbarNav.contains(e.target)){
                navbarNav.classList.remove('active');
            };
        });
    </script>
    <script>
        AOS.init();
    </script>
</body>
</html>