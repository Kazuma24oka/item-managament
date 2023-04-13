@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>商品一覧</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4 d-flex align-items-center">
                            <!-- 商品登録ボタン -->
                            <a href="{{ url('items/add') }}" class="btn btn-default">商品登録</a>
                        </div>
                        <div class="col-md-4">
                            <!-- 検索フォーム -->
                            <form action="{{ route('items.index') }}" method="GET" class="input-group input-group-sm no-wrap ml-auto">
                                <input type="text" class="form-control search-input" name="search" placeholder="半角スペース区切りで複数検索" value="{{ request()->query('search') }}" style="width: 100%;">
                                <button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                        <div class="col-md-2 ml-auto">
                            <a href="">ユーザー画面</a>
                        </div>
                    </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>
                                <a class="text-secondary" href="{{ route('items.index', array_merge(request()->query(), ['sort' => 'id', 'order' => (request()->query('sort') == 'id' && request()->query('order') == 'asc') ? 'desc' : 'asc'])) }}">ID</a>
                                @if(request()->query('sort') == 'id')
                                    <i class="fas fa-sort-{{ request()->query('order') == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </th>
                            <th>画像</th>
                            <th>
                                <a class="text-secondary" href="{{ route('items.index', array_merge(request()->query(), ['sort' => 'name', 'order' => (request()->query('sort') == 'name' && request()->query('order') == 'asc') ? 'desc' : 'asc'])) }}">名前</a>
                                @if(request()->query('sort') == 'name')
                                    <i class="fas fa-sort-{{ request()->query('order') == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            <th>
                                <a class="text-secondary" href="{{ route('items.index', array_merge(request()->query(), ['sort' => 'type', 'order' => (request()->query('sort') == 'type' && request()->query('order') == 'asc') ? 'desc' : 'asc'])) }}">種別</a>
                                @if(request()->query('sort') == 'type')
                                    <i class="fas fa-sort-{{ request()->query('order') == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </th>
                            <th>詳細</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td style="width: 50px;">{{ $item->id }}</td>
                                    <td><img src="{{ asset($item->image) }}" alt="Item Image" class="table-image"></td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td class="detail-cell">
                                        <span class="detail-text">{{ $item->detail }}</span>
                                        <a class="btn btn-secondary small-button" href="#" data-toggle="modal" data-target="#modal-{{ $item->id }}">詳細</a>
                                    </td>
                                    <td>
                                        <!-- 編集画面へ遷移 -->
                                        <a href="{{ route('items.edit', $item->id) }}" class=" btn btn-primary small-button">編集</a>
                                        <!-- 削除機能 -->
                                        <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('本当に削除しますか？')" class="btn btn-danger small-button">削除</button>
                                        </form>
                                    </td>
                                </tr>
                                    <!-- Include the item detail modal -->
                                    @include('item.detailmodal', ['item' => $item])
                            @endforeach
                        </tbody>
                    </table>
                </div>
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

