@extends('common._layout.main-user')

@section('content')
    <div class="flex flex-col justify-between h-full gap-32 px-8 lg:flex-row">
        <div class="flex flex-col justify-center w-full gap-5 lg:w-1/2">
            <h2 class="text-2xl font-bold">Verifikasi Email</h2>
            <form method="POST" action="{{ route('users.auth.need-verify.post') }}" class="flex flex-col gap-5">
                @csrf
                <p class="text-gray-500">Untuk melangkah lebih lanjut, masukkan kode verifikasi email dikirimkan ke email
                    anda.</p>
                <div class="flex items-center justify-center gap-2">
                    @for ($i = 0; $i < 6; $i++)
                        <input inputmode="numeric"
                            class="w-8 px-0 text-lg font-bold text-center lg:text-2xl lg:w-14 inputTokenEmail"
                            data-index="{{ $i }}">
                    @endfor
                    <input hidden name="token_email" id="tokenEmail">
                </div>
                <button id="tokenEmailSubmit" class="font-normal btn-primary">Verifikasi</button>
            </form>
            <form method="POST" action="{{ route('users.auth.need-verify.resend') }}" class="flex flex-col gap-5">
                @csrf
                <button type="submit" class="font-normal link">Kirim Ulang Kode ke Email</button>
            </form>

        </div>
        <div class="items-center hidden w-full lg:flex lg:w-1/2">
            <img src="/assets/img/auth-illustration.png" alt="Login image">
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.inputTokenEmail');
            const hiddenInput = document.getElementById('tokenEmail');

            inputs.forEach((input, index) => {
                // Handle paste event
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pastedText = (e.clipboardData || window.clipboardData).getData('text');
                    const digits = pastedText.replace(/[^0-9]/g, '').split('').slice(0, 6);

                    digits.forEach((digit, i) => {
                        if (i < inputs.length) {
                            inputs[i].value = digit;
                        }
                    });

                    const nextEmptyIndex = digits.length < inputs.length ? digits.length : inputs
                        .length - 1;
                    if (nextEmptyIndex < inputs.length) {
                        inputs[nextEmptyIndex].focus();
                    }

                    updateHiddenInput();
                });

                // Handle input for both mobile and desktop
                input.addEventListener('input', function(e) {
                    const value = this.value;

                    // Keep only the last digit
                    this.value = value.slice(-1).replace(/[^0-9]/g, '');

                    if (this.value && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }

                    updateHiddenInput();
                });

                // Handle backspace
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace') {
                        if (!this.value && index > 0) {
                            inputs[index - 1].focus();
                            e.preventDefault();
                        }
                    }
                });

                // Prevent non-numeric input
                input.addEventListener('beforeinput', function(e) {
                    if (!/^\d*$/.test(e.data)) {
                        e.preventDefault();
                    }
                });
            });

            function updateHiddenInput() {
                const combinedValue = Array.from(inputs).map(input => input.value).join('');
                hiddenInput.value = combinedValue;
            }
        });
    </script>
@endpush
