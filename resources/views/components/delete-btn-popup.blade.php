<form action="{{ $action }}" method="POST" class="inline-block delete-form">
    @csrf
    @method('DELETE')
    <button type="button" class="bg-red-500 hover:bg-red-600 text-white font-medium px-4 py-2 rounded-lg delete-btn">
        Delete Post
    </button>
</form>

{{-- Include SweetAlert2 only once --}}
@once
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('.delete-form');

                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endonce
