<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Page</title>
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="form-container">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Register</h1>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if ($errors->has('password'))
                        <div class="alert alert-danger">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">ชื่อผู้ใช้</label>
                            <input type="text" name="name" id="name" placeholder="กรอกชื่อผู้ใช้" required>
                        </div>
                        <div class="form-group">
                            <label for="email">อีเมลของคุณ</label>
                            <input type="email" name="email" id="email" placeholder="กรอกอีเมลของคุณ" required>
                        </div>
                        <div class="form-group">
                            <label for="password">รหัสผ่าน</label>
                            <input type="password" name="password" id="password" placeholder="ระบุรหัสผ่านของคุณ"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="password">ยืนยันรหัสผ่าน</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="ยืนยันรหัสผ่าน" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-primary">สมัครสมาชิก</button>
                        </div>
                    </form>
                    <div class="login-link">
                        <a href="{{ url('/login') }}">มีบัญชีอยู่แล้ว? ล็อกอิน</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
