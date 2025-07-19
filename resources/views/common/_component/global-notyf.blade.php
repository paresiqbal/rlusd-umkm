@push('scripts')
    <script>
        let hasToast = {{ !!session('globalToast') ? 'true' : 'false' }};
        let toast = @json(session('globalToast', []));

        // Create an instance of Notyf
        let notyf = new Notyf({
            duration: 2000,
            dismissible: true,
            position: {
                x: 'center',
                y: 'top',
            },
            types: [{
                type: 'warning',
                className: 'bg-orange-500'
            }, {
                type: 'info',
                className: 'bg-blue-500'
            }]
        });

        if (hasToast) {
            notyf.open({
                ...toast
            });
        }
    </script>
@endpush
