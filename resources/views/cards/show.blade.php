<x-layout>
    <div class="w-full flex justify-center items-center flex-col min-h-screen">
        <div class="w-full max-w-xs sm:max-w-sm md:max-w-md rounded-2xl overflow-hidden shadow-2xl text-center hover:scale-105 transition-transform duration-500">    
            <!-- Top Section with Icon and Gradient Background -->
            <div class="bg-gradient-to-br flex justify-center items-center">
                <img src="{{ $card->image ? asset('storage/' . $card->image) : asset('images/bg (1).jpg') }}"
                     alt="image"
                     class="w-full object-cover">
            </div>

            <!-- Bottom Section with Text -->
            <div class="bg-[#19112F] p-6 flex flex-col items-center text-white">
                <a href="/cards/{{ $card->id }}" class="text-xl font-semibold break-words">{{ $card->title }}</a>
                <p class="text-sm mt-2 text-center break-words">
                    {{ $card->description }}
                </p>
                <a href="/" class="mt-5 inline-flex items-center font-medium text-primary-600 dark:text-primary-500 hover:underline">
                    &laquo; Back to Cards
                </a>
            </div>
        </div>
        @auth
            @if (auth()->id() === $card->users_id)
                <div class="mt-10 flex space-x-4">
                    <!-- Edit Button -->
                    <a href="/cards/{{ $card->id }}/edit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition">
                        Edit
                    </a>
                    <!-- Delete Button with Swal -->
                    <form id="delete-form-{{ $card->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700 transition" onclick="confirmDelete({{ $card->id }})">
                            Delete
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
    <script>
        $(document).ready(function () {
            $('#delete-form-{{ $card->id }}').on('submit', function (event) {
                event.preventDefault(); // Mencegah form dikirim langsung
    
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Please wait...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: "/cards/{{ $card->id }}", // Corrected route
                            type: "POST", // Laravel requires DELETE, so we include _method
                            data: {
                                _token: "{{ csrf_token() }}",
                                _method: "DELETE"
                            },
                            dataType: "json",
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Success!",
                                        text: response.message,
                                        confirmButtonColor: "#3085d6"
                                    }).then(() => {
                                        window.location.href = response.redirect;
                                    });
                                }
                            },
                            error: function (xhr) {
                                let errorMessage = "An error occurred!";
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }

                                Swal.fire({
                                    icon: "error",
                                    title: "Oops!",
                                    text: errorMessage,
                                    confirmButtonColor: "#d33"
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
</x-layout>
