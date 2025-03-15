<x-layout>
    <div class="flex justify-center items-center w-full h-[150vh]">
        <form id="editCardForm" class="max-w-md mx-auto bg-black/20 backdrop-blur-lg p-6 rounded-2xl shadow-lg" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h2 class="text-2xl font-bold text-center text-white mb-4">Edit Card</h2>
        
            <div class="mb-4">
                <label for="title" class="block text-white text-sm font-semibold mb-2">Title</label>
                <input type="text" name="title" id="title" value="{{ $card->title }}" class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
        
            <div class="mb-4">
                <label for="description" class="block text-white text-sm font-semibold mb-2">Description</label>
                <textarea name="description" id="description" class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-purple-500">{{ $card->description }}</textarea>
            </div>
        
            <div class="mb-4">
                <label for="image" class="block text-white text-sm font-semibold mb-2">Upload Image</label>
                <input type="file" name="image" id="image" class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                
                <!-- Preview Image -->
                <div class="mt-2">
                    <img id="imagePreview" src="{{ asset('storage/' . $card->image) }}" alt="Current Image" class="w-full rounded-lg shadow">
                </div>
            </div>
        
            <button type="submit" class="w-full py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition">Update Card</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#editCardForm').submit(function(e) {
                e.preventDefault();
                
                let formData = new FormData(this);

                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('cards.update', $card->id) }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
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

            // Preview Image Before Upload
            $('#image').change(function(event) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                };
                reader.readAsDataURL(event.target.files[0]);
            });
        });
    </script>
</x-layout>
