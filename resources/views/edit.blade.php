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
                    @method('PUT')

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
                    <button type="submit" class="btn btn-success">Update Selected</button>
                    <button type="submit" class="btn btn-danger">Delete Selected</button>
                    <a href="{{ route('notes.index') }}" class="btn btn-info"> Back</a>
                </form>
            </div>
        </div>
    @endsection

</body>

</html>
