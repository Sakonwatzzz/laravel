<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form</title>
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    @extends('layouts.app')

    @section('content')
        <div class="card-container">
            <div class="card">
                <h1>{{ isset($note) ? 'Edit Note' : 'Create Note' }}</h1>

                <form action="{{ isset($note) ? route('notes.update', $note->id) : route('notes.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($note))
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                        <p>{{ Auth::user()->email }}</p>
                    </div>

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control"
                            value="{{ old('title', $note->title ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" id="content" class="form-control" rows="5" required>{{ old('content', $note->content ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="files">เลือกไฟล์</label>
                        <input type="file" name="files[]" id="files" multiple>

                        <!-- แสดงไฟล์ที่ถูกบันทึกไว้ก่อนหน้า -->
                        <div id="files-preview" class="preview-container">
                            @if (isset($note) && $note->files)
                                @foreach ($note->files as $file)
                                    <p>{{ $file->file_name }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="images">เลือกรูปภาพ</label>
                        <font color="red">*อัพโหลดได้เฉพาะ .jpeg , .jpg , .png หรือ เฉพาะรูปภาพเท่านั้น</font>
                        <input type="file" name="images[]" id="images" accept="image/*" multiple>

                        <!-- แสดงรูปภาพที่ถูกบันทึกไว้ก่อนหน้า -->
                        <div id="images-preview" class="preview-container">
                            @if (isset($note) && $note->images)
                                @foreach ($note->images as $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                        style="width: 100px; margin-right: 10px;">
                                @endforeach
                            @endif
                        </div>
                        @if ($errors->has('images'))
                            <p class="text-danger">{{ $errors->first('images') }}</p>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-success mt-3">
                        {{ isset($note) ? 'Update' : 'Create' }} Note
                    </button>
                    <a href="{{ route('notes.index') }}" class="btn btn-info">
                        Back
                    </a>

                </form>
            </div>
        </div>

        <!-- jQuery Script for File/ Image Preview -->
        <script>
            $('#files').on('change', function() {
                var previewContainer = $('#files-preview');
                previewContainer.empty(); // Clear previous previews

                $.each(this.files, function(index, file) {
                    previewContainer.append('<p>' + file.name + '</p>');
                });
            });

            $('#images').on('change', function() {
                var previewContainer = $('#images-preview');
                previewContainer.empty(); // Clear previous previews

                $.each(this.files, function(index, file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        previewContainer.append('<img src="' + e.target.result +
                            '" style="width: 100px; margin-right: 10px;">');
                    }
                    reader.readAsDataURL(file);
                });
            });
        </script>
    @endsection
</body>

</html>
