@extends('adminlte::page')

@section('title', '商品登録')

@section('content_header')
    <h1>商品登録</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary">
                <form method="POST" enctype="multipart/form-data" onsubmit="document.getElementById('submit-button').disabled=true;">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="file">画像</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file" name="file" onchange="previewImage()">
                                <label class="custom-file-label file-label" for="file">画像を選択</label>
                            </div>
                            <div>
                                <img id="preview-img" src="#" alt="Image preview" style="display:none;max-width:100%;height:auto;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">名前</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="名前">
                        </div>

                        <div class="form-group">
                            <label for="type">種別</label>
                            <input type="number" class="form-control" id="type" name="type" placeholder="1, 2, 3, ...">
                        </div>

                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <textarea class="form-control" id="detail" name="detail" rows="3" placeholder="詳細説明"></textarea>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="submit-button">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@stop

@section('js')
    <script src="{{ asset('js/custom.js') }}"></script>
@stop
