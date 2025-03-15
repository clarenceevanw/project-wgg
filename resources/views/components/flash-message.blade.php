<script>
        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault();
            
            Swal.fire({
                title: 'Loading...',
                text: 'Please wait while we create your account.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
    
            event.target.submit();
        });
    </script>
    
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session("success") }}',
            confirmButtonColor: '#3085d6'
        }).then(() => {
            window.location.href = "/";
        });
    </script>
    {{ session()->forget('success') }} 
@endif

@if(session('errors'))
<script>
    let errorMessages = `@foreach ($errors->all() as $error) {{ $error }}<br> @endforeach`;
    Swal.fire({
        icon: 'error',
        title: 'Oops!',
        html: errorMessages,
        confirmButtonColor: '#d33'
    });
</script>
@endif