<x-guest-layout>
    <body class="login-page bg-body-secondary">
        <!-- Session Status -->
        <div class="container-fluid">
            <div class="row justify-content-center">
            <div class="col-md-6">
                @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>
            </div>
        </div>
        
        <!--begin::Login Box-->
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <a href="#"
                        class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover">
                        <h1 class="mb-0"><b>Kasir</b>TJ</h1>
                    </a>
                </div>
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Login dengan akun Anda untuk memulai sesi</p>
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="input-group mb-2">
                            <div class="form-floating">
                                <input id="loginEmail" type="email" name="email" class="form-control" value=""
                                    placeholder="" />
                                <label for="loginEmail">Email</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                        </div>
                        @error('email')
                            <div class="text-danger mb-2">{{ $message }}</div>
                        @enderror
                        <div class="input-group mb-4">
                            <div class="form-floating">
                                <input id="loginPassword" type="password" name="password" class="form-control" placeholder="" />
                                <label for="loginPassword">Password</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                        </div>
                        @error('password')
                            <div class="text-danger mb-2">{{ $message }}</div>
                        @enderror
                        <!--begin::Row-->
                        <div class="row mb-3">
                            <div class="col-8 d-inline-flex align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="flexCheckDefault" name="remember" />
                                    <label class="form-check-label" for="flexCheckDefault"> Remember Me </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!--end::Row-->
                    </form>
                    @if (Route::has('password.request'))
                        <p class="mb-1"><a href="{{ route('password.request') }}">Lupa kata sandi?</a></p>
                    @endif
                    <p class="mb-0">
                        <a href="#" class="text-center" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="Silakan hubungi admin untuk membuat akun baru" onclick="return false;">
                            Daftar akun baru </a>
                    </p>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                                return new bootstrap.Tooltip(tooltipTriggerEl);
                            });
                        });
                    </script>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->
        <!--begin::Third Party Plugin(OverlayScrollbars)-->
        <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
            crossorigin="anonymous"></script>
        <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous">
        </script>
        <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
        <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
        <script src="{{ asset('adminlte/js/adminlte.js') }}"></script>
        <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
        <script>
            const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
            const Default = {
                scrollbarTheme: 'os-theme-light',
                scrollbarAutoHide: 'leave',
                scrollbarClickScroll: true,
            };
            document.addEventListener('DOMContentLoaded', function() {
                const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
                if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
                    OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                        scrollbars: {
                            theme: Default.scrollbarTheme,
                            autoHide: Default.scrollbarAutoHide,
                            clickScroll: Default.scrollbarClickScroll,
                        },
                    });
                }
            });
        </script>
        <!--end::OverlayScrollbars Configure-->
        <!--end::Script-->
    </body>
</x-guest-layout>
