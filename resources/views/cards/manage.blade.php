<x-layout>
    <div class="p-12 w-full min-h-screen shadow-lg rounded-xl">
        <header>
            <h1 class="text-3xl text-center font-bold my-6 uppercase text-white">
                Manage Cards
            </h1>
        </header>

        <table class="w-full table-auto rounded-sm text-white">
            <tbody>
                @unless (count($cards) == 0)
                @foreach ($cards as $card)
                <tr class="border-gray-600">
                    <td class="px-4 py-8 border-t border-b border-gray-600 text-lg">
                        <a href="/cards/{{ $card->id }}" class="text-[#f6a868] hover:underline">
                            {{ $card->title }}
                        </a>
                    </td>
                    <td class="px-4 py-8 border-t border-b border-gray-600 text-lg">
                        <a href="/cards/{{ $card->id }}/edit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition">
                            Edit
                        </a>
                    </td>
                    <td class="px-4 py-8 border-t border-b border-gray-600 text-lg">
                        <form id="delete-form-{{ $card->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700 transition" onclick="confirmDelete({{ $card->id }})">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @else
                <tr class="border-gray-600">
                    <td class="px-4 py-8 border-t border-b border-gray-600 text-lg text-center text-gray-400">
                        No cards found
                    </td>
                </tr>
                @endunless
            </tbody>
        </table>
    </div>
    @if(count($cards) > 0)
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
    @endif
</x-layout>
