<x-guest-layout>
    <div class="grid min-h-screen grid-cols-1 lg:grid-cols-2 bg-white">
        <!-- Left: Gradient panel (desktop only) -->
        <div class="relative hidden lg:flex items-center justify-center">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_113.94%_113.94%_at_50.06%_-13.94%,_#38A3A2_17%,_#343C6A_100%)]"></div>
            <div class="relative z-10 flex flex-col items-center justify-center px-8 text-center">
                <p class="text-stone-50 text-2xl font-extrabold font-[Lexend] tracking-wide">Selamat Datang!</p>
                <p class="text-stone-50 text-2xl font-extrabold font-[Lexend] tracking-wide leading-9">UD TANI JAYA</p>
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="mt-12 w-56 h-14 rounded-[50.5px] border-2 border-white flex items-center justify-center hover:bg-white/10 transition-colors">
                        <span class="text-white text-2xl font-semibold font-[Raleway]">SIGN IN</span>
                    </a>
                @else
                    <div class="mt-12 w-56 h-14 rounded-[50.5px] border-2 border-white flex items-center justify-center">
                        <span class="text-white text-2xl font-semibold font-[Raleway] opacity-60 select-none">SIGN IN</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Form, full-bleed -->
        <div class="flex flex-col justify-center px-6 md:px-10 lg:px-16 py-10 items-center">
            <h1 class="text-slate-700 font-[Raleway] font-extrabold text-3xl md:text-4xl lg:text-5xl tracking-tight mb-6">Buat Akun Kasir</h1>

            <form method="POST" action="{{ route('register') }}" class="w-full max-w-md">
                @csrf

                <div class="space-y-4 mb-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700">Nama</label>
                        <input id="name" name="name" type="text" required autofocus autocomplete="name"
                            class="mt-1 block w-full rounded-xl border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/30"
                            value="{{ old('name') }}" />
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

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
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                            class="mt-1 block w-full rounded-xl border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/30" />
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

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
                    SIGN UP
                </button>
            </form>

            <p class="mt-6 text-slate-600 text-sm">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-teal-700 hover:text-teal-800">Login</a>
            </p>
        </div>
    </div>
</x-guest-layout>
