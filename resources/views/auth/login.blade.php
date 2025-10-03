<x-guest-layout>
    <div class="grid min-h-screen grid-cols-1 lg:grid-cols-2 bg-white">
        <!-- Left: Form, full-height, no inner container card -->
        <div class="flex flex-col justify-center items-center px-6 md:px-10 lg:px-16 py-10">
            
            @if (session('status'))
            <div class="mb-5 w-full rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
            @endif
            
            <h1 class="text-slate-700 font-[Raleway] font-extrabold text-3xl md:text-4xl lg:text-5xl tracking-tight mb-6">Login Kasir TJ</h1>

            <form method="POST" action="{{ route('login') }}" class="w-full max-w-md">
                @csrf

                <div class="space-y-4 mb-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                        <input id="email" name="email" type="email" autocomplete="username" required
                            class="mt-1 block w-full rounded-xl border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/30"
                            value="{{ old('email') }}" />
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="mt-1 block w-full rounded-xl border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/30" />
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500" />
                            Remember me
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-teal-700 hover:text-teal-800">Lupa kata sandi?</a>
                        @endif
                    </div>
                </div>

                <button type="submit"
                    class="w-full rounded-full bg-slate-700 px-5 py-3 text-center font-[Raleway] text-lg font-semibold text-white shadow hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-500/30 mt-4">
                    SIGN IN
                </button>
            </form>

            <p class="mt-6 text-slate-400 text-xs">© 2025 UD TANI JAYA</p>
        </div>

        <!-- Right: Gradient panel, full-bleed on large screens -->
        <div class="relative hidden lg:flex items-center justify-center">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_113.94%_113.94%_at_50.06%_-13.94%,_#38A3A2_17%,_#343C6A_100%)]"></div>
            <div class="relative z-10 flex flex-col items-center justify-center px-8 text-center">
                <p class="text-stone-50 text-2xl font-extrabold font-[Lexend] tracking-wide">Selamat Datang!</p>
                <p class="text-stone-50 text-2xl font-extrabold font-[Lexend] tracking-wide leading-9">UD TANI JAYA</p>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="mt-12 w-56 h-14 rounded-[50.5px] border-2 border-white flex items-center justify-center hover:bg-white/10 transition-colors">
                        <span class="text-white text-2xl font-semibold font-[Raleway]">SIGN UP</span>
                    </a>
                @else
                    <div class="mt-12 w-56 h-14 rounded-[50.5px] border-2 border-white flex items-center justify-center">
                        <span class="text-white text-2xl font-semibold font-[Raleway] opacity-60 select-none">SIGN UP</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>
