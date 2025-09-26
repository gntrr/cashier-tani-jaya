<x-guest-layout>
    <body class="hold-transition login-page bg-body-secondary">
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
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="#" class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover">
                        <h1 class="mb-0"><b>Kasir</b>TJ</h1>
                    </a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Lupa kata sandi? Tidak masalah. Beri tahu kami alamat email Anda dan kami
                        akan mengirimi Anda tautan untuk mengatur kata sandi Anda yang baru.</p>
                    <form action="{{ route('password.email') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email" name="email" required autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="bi bi-envelope"></span>
                                </div>
                            </div>
                        </div>
                        @error('email')
                            <div class="text-danger mb-2">{{ $message }}</div>
                        @enderror
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Kirim Link Reset</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                    <p class="mt-3 mb-1">
                        <a href="{{ route('login') }}">Login</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5/5hb7g5/5hb7g5/5hb7g5/5hb7g5/5hb7g5/5hb7g5" crossorigin="anonymous"></script>
        <!-- Bootstrap 4 -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('adminlte/js/adminlte.js') }}"></script>
    </body>
</x-guest-layout>
