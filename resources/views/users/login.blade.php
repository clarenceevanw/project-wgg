<x-layout>
    <div class="flex justify-center items-center w-full h-screen">
        <div class="max-w-md w-full bg-[#19112F] p-6 rounded-2xl shadow-2xl text-white">
            <h2 class="text-2xl font-semibold text-center">Login</h2>

            <form id="loginForm" class="mt-4 space-y-4">
                @csrf
                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm mb-2">Email</label>
                    <input type="text" name="email" id="email"
                        class="w-full p-3 rounded bg-gray-800 text-white focus:outline-none focus:ring-0 focus:border-transparent">
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm mb-2">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full p-3 rounded bg-gray-800 text-white focus:outline-none focus:ring-0 focus:border-transparent">
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full p-3 bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                    Login
                </button>
            </form>

            <p class="text-center text-sm mt-4">
                Don't have an account? <a href="{{ route('register') }}" class="text-blue-400 hover:underline">Register</a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#loginForm").submit(function (e) {
                e.preventDefault(); // Prevent form from refreshing

                let formData = $(this).serialize();

                Swal.fire({
                    title: "Processing...",
                    text: "Please wait...",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('login.auth') }}",
                    type: "POST",
                    data: formData,
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
            });
        });
    </script>
</x-layout>
