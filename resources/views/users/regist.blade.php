<x-layout>
    <div class="flex justify-center items-center w-full min-h-screen">
        <div class="max-w-sm w-full bg-[#19112F] p-4 rounded-xl shadow-xl text-white">
            <h2 class="text-xl font-semibold text-center">Register</h2>
    
            <form id="registerForm" class="mt-3 space-y-3">
                @csrf
                <!-- Name Input -->
                <div>
                    <label for="name" class="block text-xs mb-1">Name</label>
                    <input type="text" name="name" id="name"
                        class="w-full p-2 rounded bg-gray-800 text-white text-sm focus:outline-none">
                </div>
    
                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs mb-1">Email</label>
                    <input type="email" name="email" id="email"
                        class="w-full p-2 rounded bg-gray-800 text-white text-sm focus:outline-none">
                </div>
    
                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-xs mb-1">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full p-2 rounded bg-gray-800 text-white text-sm focus:outline-none">
                </div>
    
                <!-- Confirm Password Input -->
                <div>
                    <label for="password_confirmation" class="block text-xs mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full p-2 rounded bg-gray-800 text-white text-sm focus:outline-none">
                </div>
    
                <!-- Submit Button -->
                <button type="submit"
                    class="w-full p-2 bg-blue-600 rounded-lg text-sm hover:bg-blue-700 transition">
                    Register
                </button>
            </form>
    
            <p class="text-center text-xs mt-3">
                Already have an account? <a href="{{ route('login') }}" class="text-blue-400 hover:underline">Login</a>
            </p>
        </div>
    </div>    
    
    <script>
        $(document).ready(function () {
            $("#registerForm").submit(function (e) {
                e.preventDefault(); // Mencegah refresh halaman

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
                    url: "{{ route('register.store') }}",
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
                        let errorMessages = [];
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function (key, value) {
                                errorMessages.push(value[0]);
                            });
                        } else {
                            errorMessages.push("An error occurred!");
                        }

                        Swal.fire({
                            icon: "error",
                            title: "Oops!",
                            html: errorMessages.join("<br>"),
                            confirmButtonColor: "#d33"
                        });
                    }
                });
            });
        });
    </script>
</x-layout>
