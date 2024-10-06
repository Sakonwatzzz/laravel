<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="icon" type="image/x-icon" href="/images/note.png">
    <title>หน้าเข้าสู่ระบบ</title>
</head>

<body>
    <div class="container" style="display: flex; flex-direction: column; justify-content: center; align-items: center; padding:1.5rem">
        <img src="{{ asset('images/wirte.png') }}" alt="" style="width:70px; height:70px;">
        <div class="form-container">
            <h1>เข้าสู่ระบบ</h1>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                @if ($errors->any())
                    <div class="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label for="email">ที่อยู่อีเมล</label>
                    <input type="email" name="email" id="email" placeholder="กรอกที่อยู่อีเมลของคุณ" required>
                </div>
                <div class="form-group">
                    <label for="password">รหัสผ่าน</label>
                    <input type="password" name="password" id="password" placeholder="กรอกรหัสผ่านของคุณ" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn-primary">เข้าสู่ระบบ</button>
            </form>
            <div class="register-link">
                <h6>ยังไม่มีบัญชี?</h6>
                <a href="{{ url('/register') }}" class="btn-secondary">สมัครสมาชิก</a>
            </div>
        </div>
    </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.boxShadow = '0 0 8px rgba(132, 250, 176, 0.6)';
                });
                input.addEventListener('blur', function() {
                    this.style.boxShadow = 'none';
                });
            });

            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                // ในที่นี้คุณสามารถเพิ่มการตรวจสอบฟอร์มเพิ่มเติมได้
                // ตัวอย่างเช่น ตรวจสอบความถูกต้องของอีเมลหรือความยาวของรหัสผ่าน
                this.submit();
            });
        });
    </script>
</body>

</html>
