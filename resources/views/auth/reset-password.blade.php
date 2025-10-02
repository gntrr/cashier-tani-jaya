<x-guest-layout>
    <div class="grid min-h-screen grid-cols-1 lg:grid-cols-2 bg-white">
        <!-- Left: Form, full-height, no inner container card -->
        <div class="flex flex-col justify-center items-center px-6 md:px-10 lg:px-16 py-10">
            <h1 class="text-slate-700 font-[Raleway] font-extrabold text-3xl md:text-4xl lg:text-5xl tracking-tight mb-6">Reset Password</h1>

            <div class="w-full max-w-md mb-6">
                <p class="text-slate-600 text-center text-sm leading-relaxed">
                    Silakan masukkan email dan password baru Anda untuk mengatur ulang kata sandi.
                </p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="w-full max-w-md">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="space-y-4 mb-4">
                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                        <input id="email" name="email" type="email" autocomplete="username" required autofocus
                            class="mt-1 block w-full rounded-xl border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/30"
                            value="{{ old('email', $request->email) }}" />
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700">Password Baru</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                            class="mt-1 block w-full rounded-xl border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/30" />
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Konfirmasi Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                            class="mt-1 block w-full rounded-xl border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/30" />
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button type="submit"
                    class="w-full rounded-full bg-slate-700 px-5 py-3 text-center font-[Raleway] text-lg font-semibold text-white shadow hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-500/30 mt-4">
                    RESET PASSWORD
                </button>
            </form>

            <p class="mt-8 text-slate-400 text-xs">© 2025 UD TANI JAYA</p>
        </div>

        <!-- Right: Gradient panel, full-bleed on large screens -->
        <div class="relative hidden lg:flex items-center justify-center">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_113.94%_113.94%_at_50.06%_-13.94%,_#38A3A2_17%,_#343C6A_100%)]"></div>
            <div class="relative z-10 flex flex-col items-center justify-center px-8 text-center">
                <p class="text-stone-50 text-2xl font-extrabold font-[Lexend] tracking-wide">Password Baru</p>
                <p class="text-stone-50 text-2xl font-extrabold font-[Lexend] tracking-wide leading-9">UD TANI JAYA</p>
                <div class="mt-12 w-56 h-14 rounded-[50.5px] border-2 border-white flex items-center justify-center">
                    <span class="text-white text-2xl font-semibold font-[Raleway] opacity-60 select-none">RENEW</span>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
