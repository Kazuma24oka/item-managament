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
                            @can('manage-items')
                            <a href="{{ url('items/add') }}" class="btn btn-default">商品登録</a>
                            @endcan
                        </div>
                        <div class="col-md-4">
                            <!-- 検索フォーム -->
                            <form action="{{ route('items.index') }}" method="GET" class="input-group input-group-sm no-wrap ml-auto">
                                <input type="text" class="form-control search-input" name="search" placeholder="半角スペース区切りで複数検索" value="{{ request()->query('search') }}" style="width: 100%;">
                                <button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                        <div class="col-md-4 d-flex justify-content-end align-items-center">
                        <a href="{{ route('favorites.index') }}" class="btn btn-default">お気に入りのみ表示</a>
                        </div>
                    </div>
                <div class="card-body table-responsive p-0">
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap ">
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
                                    <td style="width: 50px; text-align: left; vertical-align: middle;">{{ $item->id }}</td>
                                    <td><img src="{{ asset($item->image) }}" alt="Item Image" class="table-image"></td>
                                    <td style="text-align: left; vertical-align: middle;">{{ Str::limit($item->name, 25, '...') }}</td>
                                    <td style="text-align: left; vertical-align: middle;">{{ $item->type }}</td>
                                    <td class="detail-cell">
                                        <span class="detail-text">{{ Str::limit($item->detail, 50, '...') }}</span>
                                        <a class="btn btn-secondary small-button detail-button" href="#" data-toggle="modal" data-target="#modal-{{ $item->id }}">詳細</a>
                                    </td>
                                    <td style="display: flex; align-items: center;">
                                        @can('manage-items')
                                        <!-- 編集画面へ遷移 -->
                                        <a href="{{ route('items.edit', $item->id) }}" class="btn btn-primary small-button">編集</a>
                                        <!-- 削除機能 -->
                                        <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('本当に削除しますか？')" class="btn btn-danger small-button">削除</button>
                                        </form>
                                        @endcan
                                        @if (Auth::user()->favorites->where('item_id', $item->id)->isEmpty())
                                            <form action="{{ route('favorite.store', $item->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success">☆</button>
                                            </form>
                                        @else
                                            <form action="{{ route('favorite.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-success">★</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                    <!-- Include the item detail modal -->
                                    @include('item.detailmodal', ['item' => $item])
                            @endforeach
                        </tbody>
                    </table>
                    <div style="display: flex; justify-content: center;">
                    {{ $items->links('pagination::bootstrap-4') }} <!-- ページネーションを追加 -->
                    </div>
                </div>
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
