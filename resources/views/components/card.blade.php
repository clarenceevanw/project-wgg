@props(['card'])

<div class="max-w-sm rounded-2xl overflow-hidden shadow-2xl text-center hover:scale-105 transition ease-in-out duration-500">
    <!-- Top Section with Image -->
    <div class="w-full h-48 overflow-hidden">
        <img src="{{ $card->image ? asset('storage/' . $card->image) : asset('images/bg (1).jpg') }}" 
             alt="image"
             class="w-full h-full object-cover">
    </div>

    <!-- Bottom Section with Text -->
    <div class="bg-[#19112F] p-6 h-[15rem] flex flex-col justify-center text-white">
        <a href="/cards/{{ $card->id }}" class="text-xl font-semibold">{{ $card->title }}</a>
        <p class="text-sm mt-2">
            {{ Str::limit($card->description, 100) }}
        </p>
        <a href="/cards/{{ $card->id }}" 
           class="text-center flex justify-center items-center mt-2 font-bold text-primary-600 dark:text-primary-500 hover:underline">
            Read more
            <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" 
                      d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" 
                      clip-rule="evenodd">
                </path>
            </svg>
        </a>
    </div>
</div>
