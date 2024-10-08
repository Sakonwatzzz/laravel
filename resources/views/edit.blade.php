<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('css/edit.css') }}" rel="stylesheet">
</head>

<body>
    @extends('layouts.app')

    @section('content')
        <div class="card-container">
            <div class="card">
                <h1 class="mb-4">แก้ไขโน้ต</h1>

                <form action="{{ route('notes.update', $note->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($note))
                        @method('PUT')
                    @endif
                    <div class="form-group">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" id="title" name="title" class="form-control"
                            value="{{ old('title', $note->title) }}">
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content" class="form-label">Content</label>
                        <textarea id="content" name="content" class="form-control">{{ old('content', $note->content) }}</textarea>
                        @error('content')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
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

                </form>
                <form action="{{ route('notes.deleteFiles', $note->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="form-group">
                        <label class="form-label">Existing Files</label>
                        <div>
                            @foreach ($note->files as $file)
                                <input type="checkbox" name="delete_files[]" value="{{ $file->id }}">
                                <a href="{{ Storage::url($file->file_path) }}" class="d-block">{{ $file->file_name }}</a>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Existing Images</label>
                        <div>
                            @foreach ($note->images as $image)
                                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}">
                                <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->image_name }}"
                                    class="img-thumbnail me-2" style="max-width: 150px;">
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger">Delete Selected</button>
                    <a href="{{ route('notes.index') }}" class="btn btn-info"> Back</a>
                </form>
            </div>
        </div>
    @endsection

</body>

</html>
