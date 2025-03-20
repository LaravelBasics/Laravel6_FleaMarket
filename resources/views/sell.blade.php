@extends('layouts.app')

@section('title')
商品出品
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8 offset-2">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-8 offset-2 bg-white">
            <div class="font-weight-bold text-center border-bottom pb-3 pt-3" style="font-size: 24px">商品を出品する</div>

            <form method="POST" action="{{ route('sell') }}" class="p-5" enctype="multipart/form-data">
                @csrf

                {{-- 商品画像 --}}
                <div>商品画像</div>
                <span class="item-image-form image-picker">
                    <!-- ファイル選択用の input は削除 -->
                    <label for="item-image" class="d-inline-block" role="button" id="image-label">
                        <img id="preview-image" src="{{ asset('images/test0.jpg') }}" style="object-fit: cover; width: 300px; height: 300px;">
                    </label>
                </span>

                <!-- 隠しフィールドに選択された画像名をセット -->
                <input type="hidden" name="selected-image" id="selected-image" value="test0.jpg">  <!-- 追加 -->

                @error('item-image')
                <div style="color: #E4342E;" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror

                {{-- 商品名 --}}
                <div class="form-group mt-3">
                    <label for="name">商品名</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                {{-- 商品の説明 --}}
                <div class="form-group mt-3">
                    <label for="description">商品の説明</label>
                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required autocomplete="description" autofocus>{{ old('description') }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                {{-- カテゴリ --}}
                <div class="form-group mt-3">
                    <label for="category">カテゴリ</label>
                    <select name="category" class="custom-select form-control @error('category') is-invalid @enderror">
                        @foreach ($categories as $category)
                        <optgroup label="{{$category->name}}">
                            @foreach($category->secondaryCategories as $secondary)
                            <option value="{{$secondary->id}}" {{old('category') == $secondary->id ? 'selected' : ''}}>{{ $secondary->name }}</option>
                            @endforeach
                        </optgroup>
                        @endforeach
                    </select>
                    @error('category')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                {{-- 商品の状態 --}}
                <div class="form-group mt-3">
                    <label for="condition">商品の状態</label>
                    <select name="condition" class="custom-select form-control @error('condition') is-invalid @enderror">
                        @foreach ($conditions as $condition)
                        <option value="{{$condition->id}}" {{old('condition') == $condition->id ? 'selected' : ''}}>{{ $condition->name }}</option>
                        @endforeach
                    </select>
                    @error('condition')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                {{-- 販売価格 --}}
                <div class="form-group mt-3">
                    <label for="price">販売価格</label>
                    <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" required autocomplete="price" autofocus>
                    @error('price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-0 mt-3">
                    <button type="submit" class="btn btn-block btn-secondary">
                        出品する
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    let imageCounter = 0; // カウンタの初期化

    // 画像選択の処理
    document.getElementById('image-label').addEventListener('click', function() {
        // 画像を切り替える
        const imageNames = ['test0.jpg', 'test1.jpg', 'test2.jpg', 'test3.jpg'];
        
        // カウンタで次の画像を選択
        imageCounter = (imageCounter + 1) % imageNames.length;

        // 選択した画像のsrcを更新
        document.getElementById('preview-image').src = "{{ asset('images/') }}/" + imageNames[imageCounter];

        // 隠しフィールドに選択した画像の名前を設定
        document.getElementById('selected-image').value = imageNames[imageCounter];
    });
</script>
@endsection
