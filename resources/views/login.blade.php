<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="form-container">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Login</h1>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="email">ที่อยู่อีเมล</label>
                            <input type="email" name="email" id="email" placeholder="กรอกที่อยู่อีเมลของคุณ"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="password">รหัสผ่าน</label>
                            <input type="password" name="password" id="password" placeholder="กรอกรหัสผ่านของคุณ"
                                required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-primary">ล็อกอิน</button>
                        </div>
                    </form>
                    <div class="register-link">
                        <h6>ยังไม่มีบัญชี?</h6>
                        <a href="{{ url('/register') }}" class="btn-secondary">สมัคร</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
