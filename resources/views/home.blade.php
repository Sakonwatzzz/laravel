<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/images/note.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">


</head>

<body>
    @extends('layouts.app')
    @section('content')
        <nav>
            <div class="container">
                <div class="context">
                    <h1>ยินดีต้อนรับ, {{ Auth::user()->name }}</h1>
                    <h3>นี่คือโน๊ตของคุณ</h3>
                </div>
                <div class="form-btn">
                    <form action="{{ route('home') }}" method="GET">
                        <input type="text" name="query" placeholder="ค้นหาข้อมูล...">
                        <button type="submit">ค้นหา</button>
                        <a href="home">หน้าหลัก</a>
                    </form>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
        <div class="card-container">
            <ul>
                <li>
                    <a href="form">เพิ่มข้อมูล</a>
                    <i class="fa-solid fa-plus"></i>
                </li>
            </ul>

            <div class="blox">
                <h4>จำนวนการบันทึกโน๊ตของคุณคือ {{ $notes->count() }}</h4>
            </div>

            <div class="grid-container">

                @if (isset($notes) && !$notes->isEmpty())
                    @foreach ($notes as $note)
                        <div class="card">
                            <h2>{{ $note->title }}</h2>
                            <p>{{ $note->content }}</p>
                            <p><small>สร้างโน๊ตนี้เมื่อ {{ $note->created_at->format('d-m-Y H:i:s') }}</small></p>
                            <p><small>แก้ไขล่าสุด {{ $note->updated_at->format('d-m-Y H:i:s') }}</small></p>

                            @if ($note->files->isNotEmpty())
                                <h3>ไฟล์</h3>
                                <ul>
                                    @foreach ($note->files as $file)
                                        <li>
                                            <a href="{{ asset('storage/' . $file->file_path) }}"
                                                target="_blank">{{ $file->file_name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            @if ($note->images->isNotEmpty()) 
                                <h3>รูปภาพ</h3>
                                <div class="image-gallery">
                                    @foreach ($note->images as $image)
                                        <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->image_name }}">
                                    @endforeach
                                </div>
                            @endif
                            <div class="form-btn-ed">
                                <button type="button" class="btn btn-danger delete-btn"
                                    data-id="{{ $note->id }}">Delete</button>
                                <form action="{{ route('notes.edit', $note->id) }}" method="GET" style="display:inline;">
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>ไม่พบรายการโน๊ตของท่าน กรุณากรอกฟอร์มก่อน</p>
                @endif
            </div>
        </div>
    @endsection
</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success", // ปุ่มสีเขียวสำหรับการลบ
                cancelButton: "btn btn-danger" // ปุ่มสีแดงสำหรับการยกเลิก
            },
            buttonsStyling: false
        });

        // ฟังก์ชันการทำงานของปุ่มลบ
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const noteId = this.getAttribute('data-id');
                swalWithBootstrapButtons.fire({
                    title: "คุณแน่ใจหรือไม่?",
                    text: "คุณจะไม่สามารถเปลี่ยนกลับสิ่งนี้ได้!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "ใช่, ลบเลย!",
                    cancelButtonText: "ไม่, ยกเลิก!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/notes/${noteId}`;
                        form.innerHTML = `
                           <input type="hidden" name="_method" value="DELETE">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                       `;
                        document.body.appendChild(form);
                        form.submit();
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                            'ยกเลิกแล้ว',
                            'โน้ตของคุณยังคงอยู่ :)',
                            'error'
                        );
                    }
                });
            });
        });
    });
</script>



</html>
