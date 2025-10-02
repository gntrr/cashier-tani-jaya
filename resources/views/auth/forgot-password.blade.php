<x-guest-layout>   
    <div class="grid min-h-screen grid-cols-1 lg:grid-cols-2 bg-white">
        <!-- Left: Form, full-height, no inner container card -->
        <div class="flex flex-col justify-center items-center px-6 md:px-10 lg:px-16 py-10">
            @if (session('status'))
                <div class="mb-6 w-full max-w-md rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif
            
            <h1 class="text-slate-700 font-[Raleway] font-extrabold text-3xl md:text-4xl lg:text-5xl tracking-tight mb-6">Lupa Password</h1>


            <div class="w-full max-w-md mb-6">
                <p class="text-slate-600 text-center text-sm leading-relaxed">
                    Lupa kata sandi? Tidak masalah. Beri tahu kami alamat email Anda dan kami akan mengirimi Anda tautan untuk mengatur kata sandi Anda yang baru.
                </p>
            </div>

            <form method="POST" action="{{ route('password.email') }}" class="w-full max-w-md">
                @csrf

                <div class="space-y-4 mb-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                        <input id="email" name="email" type="email" autocomplete="username" required autofocus
                            class="mt-1 block w-full rounded-xl border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/30"
                            value="{{ old('email') }}" />
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button type="submit"
                    class="w-full rounded-full bg-slate-700 px-5 py-3 text-center font-[Raleway] text-lg font-semibold text-white shadow hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-500/30 mt-4">
                    KIRIM LINK RESET
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm font-medium text-teal-700 hover:text-teal-800">Kembali ke Login</a>
            </div>

            <p class="mt-8 text-slate-400 text-xs">© 2025 UD TANI JAYA</p>
        </div>

        <!-- Right: Gradient panel, full-bleed on large screens -->
        <div class="relative hidden lg:flex items-center justify-center">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_113.94%_113.94%_at_50.06%_-13.94%,_#38A3A2_17%,_#343C6A_100%)]"></div>
            <div class="relative z-10 flex flex-col items-center justify-center px-8 text-center">
                <p class="text-stone-50 text-2xl font-extrabold font-[Lexend] tracking-wide">Reset Password</p>
                <p class="text-stone-50 text-2xl font-extrabold font-[Lexend] tracking-wide leading-9">UD TANI JAYA</p>
                <div class="mt-12 w-56 h-14 rounded-[50.5px] border-2 border-white flex items-center justify-center">
                    <span class="text-white text-2xl font-semibold font-[Raleway] opacity-60 select-none">RECOVERY</span>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
