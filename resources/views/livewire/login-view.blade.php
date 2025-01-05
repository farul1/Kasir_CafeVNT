<div class="login-form">
    <center>
        <img class="login-logo" src="{{ asset('img/logo.png') }}" alt="Logo">
    </center>
    <div class="login-line"></div>

    @if(session()->has('loginFailed'))
        <div class="alert alert-danger">
            <i class="fa-solid fa-circle-xmark"></i>&nbsp;&nbsp;{{ session('loginFailed') }}
        </div>
    @endif

    <!-- Form Login -->
    <form action="/login" method="post" autocomplete="off">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">
                <i class="fa-solid fa-user"></i>&nbsp;&nbsp;Username
            </label>
            <input type="text"
                   class="form-control shadow-none @error('username') is-invalid @enderror"
                   id="username"
                   name="username"
                   value="{{ old('username') }}"
                   placeholder="Masukkan Username"
                   autocomplete="off">

            @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">
                <i class="fa-solid fa-key"></i>&nbsp;&nbsp;Password
            </label>
            <input type="password"
                   class="form-control shadow-none @error('password') is-invalid @enderror"
                   id="password"
                   name="password"
                   placeholder="Masukkan Password"
                   autocomplete="new-password">

            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Checkbox untuk menampilkan password -->
        <div class="mb-3">
            <input class="form-check-input shadow-none"
                   type="checkbox"
                   id="show-password"
                   onclick="showPasswordHandler()">
            <label class="form-check-label" for="show-password">
                Tampilkan Password
            </label>
        </div>

        <!-- Tombol Login -->
        <button type="submit" class="btn btn-login shadow-none">
            <i class="fa-solid fa-arrow-right-to-bracket"></i>&nbsp;&nbsp;Login
        </button>
    </form>
</div>

<script>
    // Fungsi untuk menampilkan dan menyembunyikan password
    function showPasswordHandler() {
        var passwordField = document.getElementById('password');
        if (document.getElementById('show-password').checked) {
            passwordField.type = 'text';
        } else {
            passwordField.type = 'password';
        }
    }
</script>
