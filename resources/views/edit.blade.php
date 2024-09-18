<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>แก้ไขโน้ต</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/edit.css')}}">
</head>
<body>
    @extends('layouts.app')
    @section('content')
        <div class="card-container">
            <div class="card">
                <h1>แก้ไขโน้ต</h1>

                <form action="{{ route('notes.update', $note->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="title">หัวข้อ</label>
                        <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $note->title) }}" required>
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content">เนื้อหา</label>
                        <textarea id="content" name="content" class="form-control" required>{{ old('content', $note->content) }}</textarea>
                        @error('content')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="files">เลือกไฟล์</label>
                        <div class="file-input-wrapper">
                            <button class="btn-file">เลือกไฟล์ <i class="fas fa-file-upload"></i></button>
                            <input type="file" name="files[]" id="files" multiple>
                        </div>
                        <div id="files-preview" class="preview-container">
                            <!-- ไฟล์ที่เลือกใหม่จะแสดงที่นี่ -->
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="images">เลือกรูปภาพ</label>
                        <p class="text-danger"><i class="fas fa-exclamation-triangle"></i> อัพโหลดได้เฉพาะ .jpeg, .jpg, .png</p>
                        <div class="file-input-wrapper">
                            <button class="btn-file">เลือกรูปภาพ <i class="fas fa-image"></i></button>
                            <input type="file" name="images[]" id="images" accept="image/*" multiple>
                        </div>
                        <div id="images-preview" class="preview-container">
                            <!-- รูปภาพที่เลือกใหม่จะแสดงที่นี่ -->
                        </div>
                        @if ($errors->has('images'))
                            <p class="text-danger">{{ $errors->first('images') }}</p>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> อัพเดทโน้ต
                    </button>
                </form>

                <form action="{{ route('notes.deleteFiles', $note->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="form-group existing-files">
                        <label>ไฟล์ที่มีอยู่</label>
                        @foreach ($note->files as $file)
                            <div class="checkbox-wrapper">
                                <input type="checkbox" name="delete_files[]" value="{{ $file->id }}">
                                <a href="{{ Storage::url($file->file_path) }}">{{ $file->file_name }}</a>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group existing-images">
                        <label>รูปภาพที่มีอยู่</label>
                        @foreach ($note->images as $image)
                            <div class="checkbox-wrapper">
                                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}">
                                <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->image_name }}" class="img-thumbnail" style="max-width: 100px;">
                            </div>
                        @endforeach
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> ลบรายการที่เลือก
                        </button>
                        <a href="{{ route('notes.index') }}" class="btn btn-info">
                            <i class="fas fa-arrow-left"></i> กลับ
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <script>
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
                        previewContainer.append('<img src="' + e.target.result + '" alt="Preview" style="width: 100px; height: 100px; object-fit: cover; margin-right: 10px;">');
                    }
                    reader.readAsDataURL(file);
                });
            });
        </script>
    @endsection
</body>
</html>