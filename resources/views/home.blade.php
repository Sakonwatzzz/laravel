<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
</head>

<body>
    @extends('layouts.app')

    @section('content')
        <nav>
            <div class="container">
                <div>
                    <ul>
                        <li>
                            <a href="welcome">Welcome</a>
                            <a href="form">เพิ่มข้อมูล</a>
                            <a href="home">หน้าหลัก</a>
                        </li>
                    </ul>
                    <form  action="{{ route('home') }}" method="GET">
                        <input type="text" name="query" placeholder="ค้นหาข้อมูล...">
                        <button type="submit">ค้นหา</button>
                    </form>
                    <form  action="{{ route('logout') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Logout</button>
                    </form>
                    <h1>Welcome, {{ Auth::user()->name }}</h1>
                    <h3>Notes List</h3>

                </div>
            </div>
        </nav>
        <div class="card-container">

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
                        <form action="{{ route('notes.destroy', $note->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        <form action="{{ route('notes.edit', $note->id) }}" method="GET">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </form>
                    </div>
                @endforeach
            @else
                <p>ไม่พบรายการโน๊ตของท่าน กรุณากรอกฟอร์มก่อน</p>
            @endif
        </div>
    @endsection
</body>
</html>
