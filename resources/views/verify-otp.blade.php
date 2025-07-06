<x-auth-layout>
    <x-slot:heading>
        Email Verification
    </x-slot:heading>

    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
        <div class="text-center mb-6">
            <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Check Your Email</h2>
            <p class="text-gray-600 mt-2">
                We've sent a 6-digit verification code to<br>
                <span class="font-semibold text-blue-600">{{ $email }}</span>
            </p>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('verify.otp.submit') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="user_type" value="{{ $userType }}">

            <div>
                <label for="otp_code" class="block text-sm font-medium text-gray-700 mb-2">
                    Verification Code
                </label>
                <input
                    type="text"
                    id="otp_code"
                    name="otp_code"
                    maxlength="6"
                    pattern="[0-9]{6}"
                    placeholder="Enter 6-digit code"
                    class="w-full px-4 py-3 text-center text-2xl tracking-widest border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('otp_code') border-red-500 @enderror"
                    value="{{ old('otp_code') }}"
                    required
                    autocomplete="off"
                >
                @error('otp_code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 font-medium transition duration-200"
            >
                Verify & Create Account
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600 mb-3">
                Didn't receive the code?
            </p>

            <form method="POST" action="{{ route('resend.otp') }}" class="inline">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="user_type" value="{{ $userType }}">
                <button
                    type="submit"
                    class="text-blue-600 hover:text-blue-800 font-medium text-sm underline"
                >
                    Resend verification code
                </button>
            </form>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200 text-center">
            <p class="text-xs text-gray-500">
                The verification code expires in 15 minutes.<br>
                If you're having trouble, please contact support.
            </p>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-gray-800">
                ← Back to registration
            </a>
        </div>
    </div>

    <script>
        // Auto-focus on the OTP input
        document.getElementById('otp_code').focus();

        // Auto-submit when 6 digits are entered
        document.getElementById('otp_code').addEventListener('input', function(e) {
            if (e.target.value.length === 6 && /^\d{6}$/.test(e.target.value)) {
                e.target.form.submit();
            }
        });

        // Only allow numbers
        document.getElementById('otp_code').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });
    </script>
</x-auth-layout>
