<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Page</title>
    <link rel="icon" type="image/x-icon" href="/images/note.png">

    <link href="{{ asset('css/search.css') }}" rel="stylesheet">
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
                            <a href="form">Form</a>
                            <a href="home">Home</a>
                        </li>
                    </ul>
                    <form action="{{ route('search') }}" method="GET">
                        <input type="text" name="query" placeholder="ค้นหาข้อมูล...">
                        <button type="submit">ค้นหา</button>
                    </form>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Logout</button>
                    </form>
                    <h1>รายการของ {{ Auth::user()->email }}</h1>
                </div>
            </div>
        </nav>
        <div class="card-container">
            @if ($results->isEmpty())
                <p>ไม่พบข้อมูลที่คุณค้นหา</p>
            @else
                @foreach ($results as $result)
                    <div class="card">
                        <h2>{{ $result->title }}</h2>
                        <p>{{ $result->content }}</p>

                        @if ($result->files->isNotEmpty())
                            <h3>ไฟล์:</h3>
                            <ul>
                                @foreach ($result->files as $file)
                                    <li>
                                        <a href="{{ Storage::url($file->file_path) }}" download>{{ $file->file_name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        @if ($result->images->isNotEmpty())
                            <h3>รูปภาพ:</h3>
                            <div class="image-gallery">
                                @foreach ($result->images as $image)
                                    <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->image_name }}">
                                @endforeach
                            </div>
                        @endif

                        @isset($notes)
                            @foreach ($notes as $note)
                                <form action="{{ route('notes.destroy', $note->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            @endforeach
                        @endisset
                    </div>
                @endforeach
            @endif

        </div>
    @endsection
</body>

</html>
