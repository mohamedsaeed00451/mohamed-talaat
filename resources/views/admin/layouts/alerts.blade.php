<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

    .swal2-popup {
        font-family: 'Cairo', sans-serif !important;
    }

    .swal2-container {
        z-index: 99999999 !important;
    }

    .swal2-confirm, .swal2-cancel {
        transition: all 0.3s ease !important;
    }

    .swal2-confirm:hover:not([disabled]) {
        transform: translateY(-2px) !important;
        box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.5) !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                popup: 'rounded-[2rem] shadow-2xl border border-gray-100 p-6',
                title: 'text-2xl font-black text-gray-800',
                htmlContainer: 'text-gray-500 font-bold',
                actions: 'flex gap-4 w-full justify-center mt-8',
                confirmButton: 'cursor-pointer flex items-center justify-center gap-2 rounded-xl px-8 py-3.5 font-black bg-red-500 text-white shadow-lg shadow-red-500/30',
                cancelButton: 'cursor-pointer rounded-xl px-8 py-3.5 font-bold border border-gray-200 bg-gray-50 text-gray-700 shadow-sm hover:bg-gray-200'
            },
            buttonsStyling: false
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if (session('success'))
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            customClass: {popup: 'rounded-[1.5rem] shadow-xl border border-gray-100'}
        });
        @endif

        @if (session('error'))
        Toast.fire({
            icon: 'error',
            title: '{{ session('error') }}',
            customClass: {popup: 'rounded-[1.5rem] shadow-xl border border-gray-100'}
        });
        @endif

        @if ($errors->any())
        swalWithBootstrapButtons.fire({
            icon: 'error',
            title: 'عذراً، يوجد خطأ!',
            html: `
                <ul class="text-sm font-bold text-red-600 space-y-2 text-right mt-4" dir="rtl">
                    @foreach ($errors->all() as $error)
            <li>• {{ $error }}</li>
                    @endforeach
            </ul>
`,
            confirmButtonText: 'حسناً فهمت',
            customClass: {
                popup: 'rounded-[2rem] shadow-2xl border border-gray-100',
                confirmButton: 'cursor-pointer rounded-xl px-10 py-3.5 font-black bg-[#1e40af] text-white shadow-lg shadow-blue-500/30 hover:-translate-y-1 transition-all'
            }
        });
        @endif

        document.body.addEventListener('submit', function (e) {
            if (e.target.classList.contains('delete-form')) {
                e.preventDefault();
                const form = e.target;
                swalWithBootstrapButtons.fire({
                    title: 'هل أنت متأكد؟',
                    text: "لن تتمكن من استرجاع البيانات بعد إتمام الحذف!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'نعم، قم بالحذف!',
                    cancelButtonText: 'إلغاء',
                    reverseButtons: true,
                    showLoaderOnConfirm: true,
                    allowOutsideClick: () => !Swal.isLoading(),
                    preConfirm: () => {
                        Swal.showLoading();
                        form.submit();
                        return new Promise(() => {
                        });
                    }
                });
            }
        });

    });
</script>
