<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/register.css')}}">
    <title>หน้าสมัครสมาชิก</title>
</head>
<body>
    <div class="container">
        <h1>สมัครสมาชิก</h1>
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
                <input type="password" name="password" id="password" placeholder="ระบุรหัสผ่านของคุณ" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">ยืนยันรหัสผ่าน</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="ยืนยันรหัสผ่าน" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn-primary">สมัครสมาชิก</button>
            </div>
        </form>
        <div class="login-link">
            <a href="{{ url('/login') }}">มีบัญชีอยู่แล้ว? ล็อกอิน</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.boxShadow = '0 0 8px rgba(161, 196, 253, 0.6)';
                });
                input.addEventListener('blur', function() {
                    this.style.boxShadow = 'none';
                });
            });

            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                // ตรวจสอบความถูกต้องของฟอร์มก่อนส่ง
                if (validateForm()) {
                    this.submit();
                }
            });

            function validateForm() {
                const password = document.getElementById('password');
                const passwordConfirmation = document.getElementById('password_confirmation');
                if (password.value !== passwordConfirmation.value) {
                    alert('รหัสผ่านและการยืนยันรหัสผ่านไม่ตรงกัน');
                    return false;
                }
                return true;
            }
        });
    </script>
</body>
</html>