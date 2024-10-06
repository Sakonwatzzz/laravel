<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($note) ? 'Edit Note' : 'Create Note' }}</title>
    <link rel="icon" type="image/x-icon" href="/images/note.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>

<body>
    @extends('layouts.app')

    @section('content')
        <div class="card-container">
            <div class="card">
                <h1>{{ isset($note) ? 'แก้ไขโน้ต' : 'สร้างโน้ตใหม่' }}</h1>

                <form action="{{ isset($note) ? route('notes.update', $note->id) : route('notes.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($note))
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="email">อีเมล</label>
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                        <p>{{ Auth::user()->email }}</p>
                    </div>

                    <div class="form-group">
                        <label for="title">หัวข้อ</label>
                        <input type="text" name="title" id="title" class="form-control"
                            value="{{ old('title', $note->title ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="content">เนื้อหา</label>
                        <textarea name="content" id="content" class="form-control" rows="3" required>{{ old('content', $note->content ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="files">เลือกไฟล์</label>
                        <div class="file-input-wrapper">
                            <button class="btn-file">เลือกไฟล์ <i class="fas fa-file-upload"></i></button>
                            <input type="file" name="files[]" id="files" multiple>
                        </div>
                        <div id="files-preview" class="preview-container">
                            @if (isset($note) && $note->files)
                                @foreach ($note->files as $file)
                                    <p><i class="fas fa-file"></i> {{ $file->file_name }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="images">เลือกรูปภาพ</label>
                        <p class="text-danger"><i class="fas fa-exclamation-triangle"></i> อัพโหลดได้เฉพาะ .jpeg, .jpg, .png
                        </p>
                        <div class="file-input-wrapper">
                            <button class="btn-file">เลือกรูปภาพ <i class="fas fa-image"></i></button>
                            <input type="file" name="images[]" id="images" accept="image/*" multiple>
                        </div>
                        <div id="images-preview" class="preview-container">
                            @if (isset($note) && $note->images)
                                @foreach ($note->images as $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Preview">
                                @endforeach
                            @endif
                        </div>
                        @if ($errors->has('images'))
                            <p class="text-danger">{{ $errors->first('images') }}</p>
                        @endif
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> {{ isset($note) ? 'อัพเดท' : 'สร้าง' }} โน้ต
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-info">
                            <i class="fas fa-arrow-left"></i> กลับ
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <script>
            $(document).ready(function() {

                @if (session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: "{{ session('success') }}",
                        showConfirmButton: true,
                        confirmButtonText: 'OK'
                    });
                @endif
            });
            $('#files').on('change', function() {
                var previewContainer = $('#files-preview');
                previewContainer.empty();

                $.each(this.files, function(index, file) {
                    previewContainer.append('<p><i class="fas fa-file"></i> ' + file.name + '</p>');
                });
            });

            $('#images').on('change', function() {
                var previewContainer = $('#images-preview');
                previewContainer.empty();

                $.each(this.files, function(index, file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        previewContainer.append('<img src="' + e.target.result +
                            '" alt="Preview">');
                    }
                    reader.readAsDataURL(file);
                });
            });
            $('form').on('submit', function(e) {
                e.preventDefault(); // หยุดการส่งฟอร์มทันที

                Swal.fire({
                    title: "{{ isset($note) ? 'อัพเดท' : 'สร้าง' }} โน้ต?",
                    text: "คุณต้องการบันทึกการเปลี่ยนแปลงหรือไม่?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "{{ isset($note) ? 'ใช่, อัพเดท' : 'ใช่, สร้าง' }}",
                    cancelButtonText: "ไม่, ยกเลิก!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // ถ้าผู้ใช้กดปุ่ม "ยืนยัน" จะทำการ submit ฟอร์ม
                        this.submit();

                        // แจ้งเตือนว่าได้ทำการบันทึก
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "โน้ตของคุณได้ถูกบันทึกแล้ว",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            });
        </script>


    @endsection
</body>

</html>
