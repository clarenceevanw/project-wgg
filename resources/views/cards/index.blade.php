<style>
    .firefly {
        position: absolute;
        width: 5px;
        height: 5px;
        background-color: yellow;
        border-radius: 50%;
        box-shadow: 0 0 8px rgba(255, 255, 100, 0.8);
        opacity: 0;
        animation: glow 4s infinite alternate ease-in-out, move 10s infinite linear;
    }

    @keyframes glow {
        0%, 100% {
            opacity: 0.3;
            transform: scale(1);
        }
        50% {
            opacity: 1;
            transform: scale(1.3);
        }
    }

    @keyframes move {
        0% {
            transform: translate(0, 0);
        }
        25% {
            transform: translate(30px, -40px);
        }
        50% {
            transform: translate(-20px, 30px);
        }
        75% {
            transform: translate(-40px, -20px);
        }
        100% {
            transform: translate(0, 0);
        }
    }


</style>
<x-layout>
    <div class="firefly-container absolute inset-0 overflow-hidden pointer-events-none"></div>
    <div class="hero-section relative w-full h-screen flex justify-center items-center flex-col text-shadow overflow-hidden">
        <div
        data-aos="zoom-in" data-aos-duration="1000" data-aos-easing="ease-in-out"   
        class="flex justify-center items-center flex-col">
            <h1 class="text-4xl lg:text-6xl font-bold mb-1">Welcome to <span class="italic">BEYOND</span></h1>
            <p class="text-2xl">The best place to find your next card</p>
            @auth
            <a href="/cards/create" class="bg-[#f6a868] mt-4 py-2 px-4 text-white rounded-2xl hover:text-[#f6a868] hover:bg-white transition ease-in-out duration-300">Create Card</a>
            @else
            <a href="/register" class="bg-[#f6a868] mt-4 py-2 px-4 text-white rounded-2xl hover:text-[#f6a868] hover:bg-white transition ease-in-out duration-300">Sign up to Create Card</a>
            @endauth
        </div>
            
        <div class="absolute left-[-10rem] bottom-0  w-[24rem] rotate-[70deg]">
            <div data-aos="fade-left" data-aos-duration="1000" data-aos-easing="ease-in-out">
                <svg viewBox="0 0 200 150" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="cloudGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#7A04EB; stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#140536; stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <path fill="url(#cloudGradient)" d="
                        M50,40 
                        C65,20 95,20 110,40 
                        C130,35 150,50 150,70 
                        C170,75 180,100 160,120 
                        C140,140 110,130 100,120 
                        C90,140 50,140 30,120 
                        C10,100 15,75 30,70 
                        C30,55 35,45 50,40
                        Z" />
                </svg>
            </div>
        </div>        
        <div class="absolute top-0 right-[-10rem] md:right-[-11rem] lg:right-[-10rem] w-[24rem] rotate-[-75deg] scale-x-[-1]">
            <div data-aos="fade-left" data-aos-duration="1000" data-aos-easing="ease-in-out">
                <svg viewBox="0 0 200 150" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="cloudGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#7A04EB; stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#140536; stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <path fill="url(#cloudGradient)" d="
                        M50,40 
                        C65,20 95,20 110,40 
                        C130,35 150,50 150,70 
                        C170,75 180,100 160,120 
                        C140,140 110,130 100,120 
                        C90,140 50,140 30,120 
                        C10,100 15,75 30,70 
                        C30,55 35,45 50,40
                        Z" />
                </svg>
            </div>
        </div>        
    </div>
    <div class="pt-5 px-[7%] flex justify-center items-center flex-col gap-[3rem]">
        <h1 class="text-center text-4xl font-bold">Cards</h1>
        <form action="" class="px-[7%] w-full inline-block">
            <input type="text" name="search" id="search" class="w-full p-3 rounded bg-gray-800 focus:outline-none focus:ring-0 focus:border-transparent" value="{{ old('search') }}" placeholder="Search for a card">
        </form>
        
            @unless (count($cards) == 0)
            <div class="grid lg:grid-cols-3 gap-[2rem] mx-[5rem]">
                @foreach ($cards as $card)
                    <x-card :card="$card" />
                @endforeach
            </div>
                
                @else
                    <p class="text-center">No Cards found</p>
            @endunless
    </div>
    <div class="mt-6 p-4">
        {{ $cards->links() }}
    </div>
</x-layout>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const container = document.querySelector(".hero-section");
        
        for (let i = 0; i < 20; i++) {
            let firefly = document.createElement("div");
            firefly.classList.add("firefly");

            // Posisi awal acak
            firefly.style.top = Math.random() * 100 + "%";
            firefly.style.left = Math.random() * 100 + "%";

            // Random durasi animasi
            let duration = (Math.random() * 5 + 5) + "s";
            firefly.style.animationDuration = duration + ", " + duration;

            container.appendChild(firefly);
        }
    });

</script>
